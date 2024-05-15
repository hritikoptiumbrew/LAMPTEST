<?php

namespace App\Http\Controllers;

use Exception;
use FFMpeg;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class VerificationController extends Controller
{
    /* ==================================| Common verifications for all projects |====================================*/

    //validate required and empty field
    public function validateRequiredParameter($required_fields, $request_params)
    {
        $error = false;
        $error_fields = '';

        foreach ($required_fields as $key => $value) {
            if (isset($request_params->$value)) {
                if (!is_object($request_params->$value)) {
                    if (strlen($request_params->$value) == 0) {
                        $error = true;
                        $error_fields .= ' ' . $value . ',';
                    }
                }
            } else {
                $error = true;
                $error_fields .= ' ' . $value . ',';
            }
        }

        if ($error) {
            // Required field(s) are missing or empty
            $error_fields = substr($error_fields, 0, -1);
            $message = 'Required field(s)' . $error_fields . ' is missing or empty.';
            $response = Response::json(array('code' => 201, 'message' => $message, 'cause' => '', 'data' => json_decode("{}")));
        } else
            $response = '';

        return $response;
    }

    //validate required array field
    public function validateRequiredArrayParameter($required_fields, $request_params)
    {
        $error = false;
        $error_fields = '';

        foreach ($required_fields as $key => $value) {
            if (isset($request_params->$value)) {
                if (!is_array($request_params->$value)) {
                    $error = true;
                    $error_fields .= ' ' . $value . ',';
                } else {
                    if (count($request_params->$value) == 0) {
                        $error = true;
                        $error_fields .= ' ' . $value . ',';
                    }
                }
            } else {
                $error = true;
                $error_fields .= ' ' . $value . ',';
            }
        }

        if ($error) {
            // Required field(s) are missing or empty
            $error_fields = substr($error_fields, 0, -1);
            $message = 'Required field(s)' . $error_fields . ' is missing or empty.';
            $response = Response::json(array('code' => 201, 'message' => $message, 'cause' => '', 'data' => json_decode("{}")));
        } else
            $response = '';

        return $response;
    }

    //validate required field
    public function validateRequiredParam($required_fields, $request_params)
    {
        $error = false;
        $error_fields = '';

        foreach ($required_fields as $key => $value) {
            if (!(isset($request_params->$value))) {
                $error = true;
                $error_fields .= ' ' . $value . ',';
            }
        }

        if ($error) {
            // Required field(s) are missing or empty
            $error_fields = substr($error_fields, 0, -1);
            $message = 'Required field(s)' . $error_fields . ' is missing.';
            $response = Response::json(array('code' => 201, 'message' => $message, 'cause' => '', 'data' => json_decode("{}")));
        } else
            $response = '';
        return $response;
    }

    //validate required parameter by isset(), it will returns error when parameter is set but value is empty
    public function validateIssetRequiredParameter($required_fields, $request_params)
    {
        $error = false;
        $error_fields = '';

        foreach ($required_fields as $key => $value) {
            if (isset($request_params->$value)) {
                if (!is_object($request_params->$value)) {
                    if (strlen($request_params->$value) == 0) {
                        $error = true;
                        $error_fields .= ' ' . $value . ',';
                    }
                }
            }
        }

        if ($error) {
            // Required field(s) are missing or empty
            $error_fields = substr($error_fields, 0, -1);
            $message = 'Required field(s)' . $error_fields . ' is missing or empty.';
            $response = Response::json(array('code' => 201, 'message' => $message, 'cause' => '', 'data' => json_decode("{}")));
        } else
            $response = '';

        return $response;
    }

    // checkDisposableEmail
    public function checkDisposableEmail($email_id)
    {
        try {
            $checker = app()->make('email.checker');
            if ($checker->isValid($email_id)) {
                $response = '';
            } else {
                $response = Response::json(array('code' => 201, 'message' => 'Disposable email addresses are not allowed.', 'cause' => '', 'data' => json_decode("{}")));
            }
        } catch (Exception $e) {
            $response = Response::json(array('code' => 201, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));
            Log::error("checkDisposableEmail : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
        return $response;
    }

    public function checkIfAppExist($app_name, $platform)
    {
        try {
            $result = DB::select('SELECT *
                                  FROM apps
                                  WHERE name = ?  AND platform = ?', [$app_name, $platform]);
            if (count($result) > 0) {
                $response = Response::json(array('code' => 201, 'message' => 'App already exist.', 'cause' => '', 'data' => json_decode("{}")));
            } else {
                $response = '';
            }
        } catch (Exception $e) {
            $response = Response::json(array('code' => 201, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));
            Log::error("checkIfAppExist : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
        return $response;
    }

    public function checkIfPackageNameExist($app_id, $platform, $package_name)
    {
        try {
            if ($app_id) {

                $result = DB::select('SELECT *
                                  FROM apps
                                  WHERE platform =? AND package_name = ? AND id != ?', [$platform, $package_name, $app_id]);
            } else {

                $result = DB::select('SELECT *
                                  FROM apps
                                  WHERE platform =? AND package_name = ?', [$platform, $package_name]);
            }
            if (count($result) > 0) {
                $response = Response::json(array('code' => 201, 'message' => 'Package name already exist.', 'cause' => '', 'data' => json_decode("{}")));
            } else {
                $response = '';
            }
        } catch (Exception $e) {
            $response = Response::json(array('code' => 201, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));
            Log::error("checkIfPackageNameExist : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
        return $response;
    }

    public function checkIfAppExistInUpdate($name, $platform, $app_id)
    {
        try {
            $result = DB::select('SELECT *
                                  FROM apps
                                  WHERE name = ? AND platform = ? AND id != ?  AND is_active = 1', [$name, $platform, $app_id]);

            if (count($result) > 0) {
                $response = Response::json(array('code' => 201, 'message' => 'App name already exist.', 'cause' => '', 'data' => json_decode("{}")));
            } else {
                $response = '';
            }
        } catch (Exception $e) {
            $response = Response::json(array('code' => 201, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));
            Log::error("checkIfAppExistInUpdate : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
        return $response;
    }

    public function checkUrlLength($play_store_url,$app_store_url)
    {
        try {
            $play_store_length = strlen($play_store_url);
            $app_store_length = strlen($app_store_url);
            $max_length = config('constants.MAX_LENGTH_FOR_URL');
            if ($max_length < $play_store_length || $max_length < $app_store_length) {
                $response = Response::json(array('code' => 201, 'message' => 'Url length is greater than ' . $max_length, 'cause' => '', 'data' => json_decode("{}")));
            } else {
                $response = '';
            }
        } catch (Exception $e) {
            $response = Response::json(array('code' => 201, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));
            Log::error("checkUrlLength : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
        return $response;
    }

    public function getAppIDFromStore($url, $platform)
    {
        try {

            if (filter_var($url, FILTER_VALIDATE_URL) && preg_match("/(.photoadking.com)/", $url, $matches)) {
                return $response = '';
            }
            if ($platform == 1) {
                try {
                    preg_match("/id=(.*?)&/", $url . '&', $matches);
                    $package_name = $matches[1];
                    $response = '';
                } catch (Exception $e) {
                    $response = Response::json(array('code' => 201, 'message' => 'Invalid url for play store', 'cause' => '', 'data' => json_decode('{}')));
                }
            }
            if ($platform == 2) {
                try {
                    $id = explode('/id', parse_url($url, PHP_URL_PATH));
                    $package_name = $id[1];
                    $response = '';
                } catch (Exception $e) {
                    $response = Response::json(array('code' => 201, 'message' => 'Invalid url for app store url', 'cause' => '', 'data' => json_decode('{}')));
                }
            }

        } catch (Exception $e) {
            $response = Response::json(array('code' => 201, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));
            Log::error("getAppIDFromStore : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
        return $response;
    }

    public function getAppIDFromStoreV2($play_store_url, $app_store_url)
    {
        try {
            if (filter_var($play_store_url, FILTER_VALIDATE_URL) && preg_match("/(.photoadking.com)/", $play_store_url, $matches)) {
                return $response = '';
            }
            if (filter_var($app_store_url, FILTER_VALIDATE_URL) && preg_match("/(.photoadking.com)/", $app_store_url, $matches)) {
                return $response = '';
            }
            if ($play_store_url) {
                try {
                    preg_match("/id=(.*?)&/", $play_store_url . '&', $matches);
                    $package_name = $matches[1];
                    $response = '';
                } catch (Exception $e) {
                    $response = Response::json(array('code' => 201, 'message' => 'Invalid url for play store', 'cause' => '', 'data' => json_decode('{}')));
                }
            }
            if ($app_store_url) {
                try {
                    $id = explode('/id', parse_url($app_store_url, PHP_URL_PATH));
                    $package_name = $id[1];
                    $response = '';
                } catch (Exception $e) {
                    $response = Response::json(array('code' => 201, 'message' => 'Invalid url for app store url', 'cause' => '', 'data' => json_decode('{}')));
                }
            }

        } catch (Exception $e) {
            $response = Response::json(array('code' => 201, 'message' => $e->getMessage(), 'cause' => '', 'data' => json_decode("{}")));
            Log::error("getAppIDFromStoreV2 : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
        return $response;
    }

    public function verifyVideo($video_array)
    {

        $video_type = $video_array->getMimeType();
        $video_size = $video_array->getSize();

        $maximum_file_size = config('constants.MAXIMUM_FILESIZE');
        $maximum_file_duration = config('constants.MAXIMUM_FILE_DURATION');
        $minimum_file_duration = config('constants.MINIMUM_FILE_DURATION');

//        $ffprobe = FFMpeg\FFProbe::create();
//
//        $duration = $ffprobe
//            ->streams($video_array)
//            ->videos()
//            ->first()
//            ->get('duration');

        if (!($video_type == 'video/mp4' || $video_type == 'video/m4v' || $video_type == 'video/avi' || $video_type == 'video/mpg' || $video_type == 'video/webm' || $video_type == 'video/mov')) {
            $response = Response::json(array('code' => 201, 'message' => "$video_type extension is not allowed.", 'cause' => '', 'data' => json_decode("{}")));

        } elseif ($video_size > $maximum_file_size) {
            $response = Response::json(array('code' => 201, 'message' => 'File size is greater then 7MB.', 'cause' => '', 'data' => json_decode("{}")));

//        } elseif ($duration > $maximum_file_duration || $duration < $minimum_file_duration) {
//            $response = Response::json(array('code' => 201, 'message' => 'File duration must be greater then' . $minimum_file_duration . 'seconds & less then' . $maximum_file_duration . ' second.', 'cause' => '', 'data' => json_decode("{}")));
        } else
            $response = '';
        return $response;
    }

}
