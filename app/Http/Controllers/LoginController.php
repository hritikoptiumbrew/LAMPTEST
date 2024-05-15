<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /* =====================================| Login |==============================================*/

    /*
    Purpose : Generate token for guest user
    Description : This method not take any argument
    Return : return Login successfully if success otherwise error with specific status code
    */
    public function doLoginForGuest()
    {
        try {

            //Mandatory field
            $email = config('constants.GUEST_USER_UD');
            $password = config('constants.GUEST_PASSWORD');
            $role_name = config('constants.ROLE_FOR_USER');

            $credential = ['email' => $email, 'password' => $password];
            if (!$token = JWTAuth::attempt($credential))
                return Response::json(array('code' => 201, 'message' => 'Invalid email or password.', 'cause' => '', 'data' => json_decode("{}")));

            /*if(!Auth::attempt($credential))
                return Response::json(array('code' => 201, 'message' => 'Invalid email or password.', 'cause' => '', 'data' => json_decode("{}")));

            if (($response = (new VerificationController())->verifyUser($email, $role_name)) != '')
                return $response;

            if (($response = (new VerificationController())->checkIfUserIsActive($email)) != '')
                return $response;

            Log::info("Login token",["token :" => $token,"time" => date('H:m:s')]);*/

            $response = Response::json(array('code' => 200, 'message' => 'Login successfully.', 'cause' => '', 'data' => ['token' => $token]));

        } catch (JWTException $e) {
            Log::error("doLoginForGuest JWTException : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => 'Could not create token.' . $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));
        } catch (Exception $e) {
            Log::error("doLoginForGuest : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'do login.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function doLoginForAdmin(Request $request_body)
    {
        try {
            $request = json_decode($request_body->getContent());
            $response = (new VerificationController())->validateRequiredParameter(array('email_id', 'password'), $request);
            if ($response != '') {
                return $response;
            }

            $email = $request->email_id;
            $password = $request->password;
            $credentials = ['email' => $email, 'password' => $password];

            if (!$token = JWTAuth::attempt($credentials)) {
                return Response::json(array('code' => 201, 'message' => 'The email and password you entered did not match our records. Please try again.', 'cause' => '', 'data' => json_decode("{}")));
            }

            //$user_id = JWTAuth::toUser($token)->id;
            $user_detail = Auth::user();
            $user_id = $user_detail->id;

            $role_id = DB::select('SELECT role_id FROM role_user WHERE user_id = ?', [$user_id]);
            $admin = config('constants.ADMIN_ID');
            $sub_admin = config('constants.SUB_ADMIN_ID');

            if (in_array("$user_id", array($admin,$sub_admin), true)) {

                if ($user_detail->google2fa_enable == 1) {
                    $this->createNewSession($user_id, $token, '', '');
                    $response = Response::json(array('code' => 200, 'message' => 'Login successfully.', 'cause' => '', 'data' => ['token' => "", 'user_detail' => $user_detail, 'role_id' => $role_id[0]->role_id]));

                } else {
                    $this->createNewSession($user_id, $token, '', '');
                    $response = Response::json(array('code' => 200, 'message' => 'Login successfully.', 'cause' => '', 'data' => ['token' => $token, 'user_detail' => $user_detail, 'role_id' => $role_id[0]->role_id]));

                }

            } else {
                $response = Response::json(array('code' => 201, 'message' => 'The email and password you entered did not match our records. Please try again..', 'cause' => '', 'data' => json_decode("{}")));
            }

        } catch (Exception $e) {
            Log::error("doLoginForAdmin : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'login for admin.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));

        }
        return $response;
    }

    public function userSignIn(Request $request_body)
    {
        try {
            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('full_name', 'social_uid', 'signup_type', 'app_json', 'device_json'), $request)) != '')
                return $response;

            $full_name = $request->full_name;
            $social_uid = $request->social_uid;
            $signup_type = $request->signup_type;
            $app_json = $request->app_json;
            $device_json = $request->device_json;

            if (($response = (new VerificationController())->validateRequiredParameter(array('app_id'), $app_json)) != '')
                return $response;
            $app_id = $app_json->app_id;

            $exist_id = DB::select('SELECT id FROM users WHERE app_id = ? AND social_uid = ? AND signup_type = ? AND is_active = 1', [$app_id, $social_uid, $signup_type]);

            if (count($exist_id) > 0) {

                $password = '$' . $social_uid . '#';
                $credential = ['social_uid' => $social_uid, 'password' => $password];
                if (!$token = JWTAuth::attempt($credential))
                    return Response::json(array('code' => 201, 'message' => 'Invalid credential.', 'cause' => '', 'data' => json_decode("{}")));

                $user_id = $exist_id[0]->id;
                $this->createNewSession($user_id, $token, $app_json, $device_json);

                $response = Response::json(array('code' => 200, 'message' => 'Login successfully.', 'cause' => '', 'data' => ['token' => $token]));

            } else {
                $email = $request->email;
                DB::beginTransaction();

                $password = '$' . $social_uid . '#';
                $db_password = Hash::make($password);

                $user_master_data = array(
                    'app_id' => $app_id,
                    'name' => $full_name,
                    'social_uid' => $social_uid,
                    'signup_type' => $signup_type,
                    'email' => $email,
                    'password' => $db_password
                );
                $user_id = DB::table('users')->insertGetId($user_master_data);

                $user_role_data = array(
                    'role_id' => config('constants.ROLE_ID_FOR_USER'),
                    'user_id' => $user_id,
                );
                DB::table('role_user')->insert($user_role_data);

                $user_details_data = array(
                    'user_id' => $user_id,
                    'full_name' => $full_name,
                    'email' => $email,
                    'app_json' => json_encode($app_json),
                    'device_json' => json_encode($device_json),
                );
                DB::table('users_detail')->insert($user_details_data);
                DB::commit();

                $credential = ['email' => $email, 'password' => $password];
                if (!$token = JWTAuth::attempt($credential))
                    return Response::json(array('code' => 201, 'message' => 'Invalid credential.', 'cause' => '', 'data' => json_decode("{}")));

                $this->createNewSession($user_id, $token, $app_json, $device_json);

                $response = Response::json(array('code' => 200, 'message' => 'Registered successfully.', 'cause' => '', 'data' => ['token' => $token]));

            }

        } catch (Exception $e) {
            Log::error("userSignIn : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'user sign-in.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
            DB::rollBack();
        }
        return $response;
    }

    public function doLogout()
    {
        try {
            $token = JWTAuth::getToken();
            $user_detail = JWTAuth::toUser($token);
            $user_id = $user_detail->id;
            JWTAuth::invalidate($token);

            DB::beginTransaction();
            DB::delete('DELETE FROM users_session WHERE token = ? AND user_id = ?', [$token, $user_id]);
            DB::commit();

            $response = Response::json(array('code' => 200, 'message' => 'Logout successfully.', 'cause' => '', 'data' => json_decode("{}")));

        } catch (Exception $e) {
            Log::error("doLogout : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'logout.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
            DB::rollBack();
        }
        return $response;
    }

    public function changePassword(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('current_password', 'new_password'), $request)) != '') {
                return $response;
            }
            //Mandatory field
            $user_data = JWTAuth::parseToken()->authenticate();
            $email_id = $user_data->email;
            $user_id = $user_data->id;
            $db_password = $user_data->password;
            $current_password = $request->current_password;
            $new_password = Hash::make($request->new_password);

            if (!Hash::check($current_password, $db_password)) {
                return Response::json(array('code' => 201, 'message' => 'Current password is incorrect.', 'cause' => '', 'data' => json_decode("{}")));
            }

            DB::beginTransaction();

            DB::update('UPDATE
                              users
                        SET
                              password = ?
                        WHERE email = ?', [$new_password, $email_id]);

            DB::delete('DELETE FROM users_session WHERE user_id = ?', [$user_id]);

            DB::commit();

            $credential = ['email' => $email_id, 'password' => $request->new_password];
            if (!$new_token = JWTAuth::attempt($credential)) {
                return Response::json(array('code' => 201, 'message' => 'Invalid email or password.', 'cause' => '', 'data' => json_decode("{}")));
            }
            $this->createNewSession($user_id, $new_token,'','');

            $response = Response::json(array('code' => 200, 'message' => 'Password changed successfully.', 'cause' => '', 'data' => ['token' => $new_token]));

        } catch (Exception $e) {
            Log::error("changePassword : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'change password.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
            DB::rollBack();
        }
        return $response;
    }

    /* =====================================| Sub-Function |==============================================*/
    public function createNewSession($user_id, $token, $app_json, $device_json)
    {
        try {
            $user_session_data = array(
                'user_id' => $user_id,
                'token' => $token,
                'app_json' => json_encode($app_json),
                'device_json' => json_encode($device_json),
            );

            DB::beginTransaction();
            DB::table('users_session')->insert($user_session_data);
            DB::commit();

            $response = array('code' => 200, 'message' => 'Session Created Successfully.', 'cause' => '', 'data' => json_decode("{}"));

        } catch (Exception $e) {
            Log::error("createNewSession : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = array('code' => 201, 'message' => config('constant.EXCEPTION_ERROR') . 'create session.', 'cause' => '', 'data' => json_decode("{}"));
            DB::rollBack();
        }
        return $response;
    }

}
