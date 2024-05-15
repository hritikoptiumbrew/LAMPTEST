<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteFileInToS3;
use App\Jobs\RunCommandAsRoot;
use App\Jobs\SendMail;
use App\Jobs\UploadFileInToS3;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    /* =========================================| Home Menu |=========================================*/
    public function getAllReportByAdmin()
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            //$redis_result = Cache::remember("getAllReportByAdmin", config('constants.CACHE_TIME_24_HOUR_IN_SEC'), function () {

            $total_user_result = DB::select('SELECT COUNT(id) AS total FROM users WHERE app_id IS NOT NULL');
            $total_app_result = DB::select('SELECT COUNT(id) AS total FROM apps');
            $total_users_feedback_result = DB::select('SELECT COUNT(id) AS total FROM users_feedback');

            $total_users = isset($total_user_result[0]->total) ? $total_user_result[0]->total : 0;
            $total_apps = isset($total_app_result[0]->total) ? $total_app_result[0]->total : 0;
            $total_users_feedback = isset($total_users_feedback_result[0]->total) ? $total_users_feedback_result[0]->total : 0;

            $redis_result = array('total_users' => $total_users, 'total_apps' => $total_apps, 'total_users_feedback' => $total_users_feedback);
            //return array('total_users' => $total_users, 'total_apps' => $total_apps, 'total_users_feedback' => $total_users_feedback);

            //});

            $response = Response::json(array('code' => 200, 'message' => 'Report fetched successfully.', 'cause' => '', 'data' => $redis_result));

        } catch (Exception $e) {
            Log::error("getAllReportByAdmin : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get report.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    /* =====================================| User Menu |==============================================*/
    public function getAllUsersByAdmin()
    {
        try {
            $token = JWTAuth::getToken();
            $this->user_detail = JWTAuth::toUser($token);
            $this->user_id = $this->user_detail->id;

            //$redis_result = Cache::rememberForever("getAllUsersByAdmin:$this->user_id", function () {

            $result = DB::select('SELECT
                                            u.id AS user_id,
                                            u.app_id AS app_id,
                                            a.name AS app_name,
                                            u.email AS email,
                                            u.created_at,
                                            u.updated_at
                                       FROM
                                            users AS u
                                       INNER JOIN apps AS a ON a.id = u.app_id
                                       WHERE u.id != ?', [$this->user_id]);

            //return array('result' => $results);
            $redis_result = array('result' => $result);

            //});

            $response = Response::json(array('code' => 200, 'message' => 'Users fetched successfully.', 'cause' => '', 'data' => $redis_result));

        } catch (Exception $e) {
            Log::error("getAllUsersByAdmin : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get all user.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function getAllRole()
    {
        try {

            return $result = DB::select('SELECT
                                              id AS role_id,
                                              display_name AS role_name
                                          FROM
                                              roles
                                          ORDER BY id');

        } catch (Exception $e) {
            Log::error("getAllRole : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get all role.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }

        return $response;
    }

    /* =========================================| App Details Menu |=========================================*/
    public function addApp(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            if (!$request_body->has('request_data'))
                return Response::json(array('code' => 201, 'message' => 'Required field request_data is missing or empty.', 'cause' => '', 'data' => json_decode("{}")));

            if (!$request_body->hasFile('file'))
                return Response::json(array('code' => 201, 'message' => 'Required field File is missing or empty.', 'cause' => '', 'data' => json_decode("{}")));

            $request = json_decode($request_body->input('request_data'));
            if (($response = (new VerificationController())->validateRequiredParameter(array('name', 'platform', 'package_name', 'play_store_url', 'app_store_url', 'slug', 'price', 'main_question', 'custom_message'), $request)) != '')
                return $response;

            $app_name = $request->name;
            $platform = $request->platform;
            $package_name = $request->package_name;
            $play_store_url = $request->play_store_url;
            $app_store_url = $request->app_store_url;
            $you_tube_url = isset($request->you_tube_url) ? $request->you_tube_url : NULL;
            $slug = $request->slug;
            $price = $request->price;
            $main_question = $request->main_question;
            $custom_message = $request->custom_message;
            $question_list = $request->question_name;
            $image_array = Input::file('file');
            $original_path = config('constants.ORIGINAL_IMAGES_DIRECTORY');
            $compressed_path = config('constants.COMPRESSED_IMAGES_DIRECTORY');
            $webp_thumbnail_path = config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY');
            $org_path = config('constants.IMAGE_BUCKET_ORIGINAL_IMG_PATH');
            $question_data = array();

            if (($response = (new VerificationController())->checkIfPackageNameExist('', $platform, $package_name)) != '')
                return $response;

            if (($response = (new VerificationController())->checkIfAppExist($app_name, $platform)) != '')
                return $response;

            if (($response = (new VerificationController())->getAppIDFromStoreV2($play_store_url, $app_store_url)) != '')
                return $response;

            if (($response = (new VerificationController())->checkUrlLength($play_store_url, $app_store_url)) != '')
                return $response;

            if (($response = (new VerificationImageController())->verifySampleImage($image_array)) != '') {
                Log::error("addApp : Validation fails.", ['response' => $response]);
                return $response;
            }

            $app_logo = (new VerificationImageController())->generateName($image_array, 'app_logo');
            (new ImageController())->saveFileByPath($image_array, $app_logo, $original_path, "original");
            (new ImageController())->saveCompressedImage($app_logo);
            $dimension = (new ImageController())->saveWebpThumbnailImage($app_logo, $original_path . $app_logo, $org_path . $app_logo);

            if (config('constants.STORAGE') == 'S3_BUCKET') {
                UploadFileInToS3::dispatch($compressed_path, $app_logo, "compressed", '');
                UploadFileInToS3::dispatch($webp_thumbnail_path, $dimension['webp_file_name'], "webp_thumbnail", '');
            }

            $app_data = array(
                'name' => $app_name,
                'image' => $app_logo,
                'webp_image' => $dimension['webp_file_name'],
                'platform' => $platform,
                'package_name' => $package_name,
                'play_store_url' => $play_store_url,
                'app_store_url' => $app_store_url,
                'youtube_url' => $you_tube_url,
                'slug' => $slug,
                'price' => $price,
                'main_question' => $main_question,
                'custom_message' => $custom_message
            );

            DB::beginTransaction();
            $app_id = DB::table('apps')->insertGetId($app_data);

            foreach ($question_list as $key => $question) {
                $question_data[$key]['name'] = $question;
                $question_data[$key]['app_id'] = $app_id;
            }
            DB::table('apps_question')->insert($question_data);
            DB::commit();

            $this->deleteAllRedisKeys("getAllAppByPlatformForAdmin");
            (new ImageController())->unlinkFileFromLocalStorage($app_logo, config('constants.ORIGINAL_IMAGES_DIRECTORY'));

            $response = Response::json(array('code' => 200, 'message' => 'App added successfully.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (Exception $e) {
            Log::error("addApp : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'add app.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
            DB::rollBack();
        }
        return $response;
    }

    public function updateApp(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            //Required parameter
            if (!$request_body->has('request_data'))
                return Response::json(array('code' => 201, 'message' => 'Required field request_data is missing or empty', 'cause' => '', 'data' => json_decode("{}")));

            $request = json_decode($request_body->input('request_data'));

            if (($response = (new VerificationController())->validateRequiredParameter(array('app_id', 'platform', 'play_store_url', 'app_store_url', 'name', 'price', 'package_name'), $request)) != '')
                return $response;

            $app_id = $request->app_id;
            $platform = $request->platform;
            $name = $request->name;
            $package_name = $request->package_name;
            $price = $request->price;
            $play_store_url = $request->play_store_url;
            $app_store_url = $request->app_store_url;
            $you_tube_url = isset($request->you_tube_url) ? $request->you_tube_url : NULL;
            $slug = isset($request->slug) ? $request->slug : '';
            $main_question = isset($request->main_question) ? $request->main_question : '';
            $custom_message = isset($request->custom_message) ? $request->custom_message : '';
            $questions = isset($request->question_name) ? $request->question_name : array();
            $question_data = array();
            $original_path = config('constants.ORIGINAL_IMAGES_DIRECTORY');
            $compressed_path = config('constants.COMPRESSED_IMAGES_DIRECTORY');
            $webp_thumbnail_path = config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY');
            $org_path = config('constants.IMAGE_BUCKET_ORIGINAL_IMG_PATH');

            if (($response = (new VerificationController())->checkIfAppExistInUpdate($name, $platform, $app_id)) != '')
                return $response;

            if (($response = (new VerificationController())->checkIfPackageNameExist($app_id, $platform, $package_name)) != '')
                return $response;

            if (($response = (new VerificationController())->getAppIDFromStoreV2($play_store_url, $app_store_url)) != '')
                    return $response;

            if (($response = (new VerificationController())->checkUrlLength($play_store_url, $app_store_url)) != '')
                    return $response;

            $result = DB::select('SELECT image, webp_image, slug, platform, package_name FROM apps WHERE id = ?', [$app_id]);
            $image_name = $result[0]->image;
            $image_webp = $result[0]->webp_image;
            $old_slug = $result[0]->slug;
            $old_platform = $result[0]->platform;
            $old_package_name = $result[0]->package_name;

            if ($request_body->hasFile('file')) {
                $image_array = Input::file('file');

                if (($response = (new VerificationImageController())->verifySampleImage($image_array)) != '') {
                    Log::error("updateApp : Validation fails.", ['response' => $response]);
                    return $response;
                }


                $app_logo = (new VerificationImageController())->generateName($image_array, 'app_logo');
                (new ImageController())->saveFileByPath($image_array, $app_logo, $original_path, "original");
                (new ImageController())->saveCompressedImage($app_logo);
                $dimension = (new ImageController())->saveWebpThumbnailImage($app_logo, $original_path . $app_logo, $org_path . $app_logo);

                if (config('constants.STORAGE') == 'S3_BUCKET') {
                    UploadFileInToS3::dispatch($compressed_path, $app_logo, "compressed", '');
                    UploadFileInToS3::dispatch($webp_thumbnail_path, $dimension['webp_file_name'], "webp_thumbnail", '');
                }

                DB::beginTransaction();
                DB::update('UPDATE
                                apps
                            SET
                                name = ?,
                                image = ?,
                                webp_image = ?,
                                platform = ?,
                                play_store_url = ?,
                                app_store_url = ?,
                                youtube_url = ?
                            WHERE
                                id = ? ',
                    [$name, $app_logo, $dimension['webp_file_name'], $platform, $play_store_url, $app_store_url, $you_tube_url, $app_id]);

                (new ImageController())->unlinkFileFromLocalStorage($app_logo, config('constants.ORIGINAL_IMAGES_DIRECTORY'));
                DeleteFileInToS3::dispatch(config('constants.COMPRESSED_IMAGES_DIRECTORY'), $image_name, "compressed");
                DeleteFileInToS3::dispatch(config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY'), $image_webp, "webp_thumbnail");

            } else {
                DB::update('UPDATE
                              apps
                            SET
                              name = ?,
                              play_store_url = ?,
                              app_store_url = ?,
                              youtube_url = ?,
                              platform = ?,
                              slug = ?,
                              price = ?,
                              main_question = ?,
                              custom_message = ?
                            WHERE
                              id = ? ',
                    [$name, $play_store_url, $app_store_url, $you_tube_url, $platform, $slug, $price, $main_question, $custom_message, $app_id]);

                if (count($questions) > 0) {

                    DB::delete('DELETE FROM apps_question WHERE app_id = ?', [$app_id]);

                    foreach ($questions as $key => $question) {
                        $question_data[$key]['name'] = $question;
                        $question_data[$key]['app_id'] = $app_id;
                    }
                    DB::table('apps_question')->insert($question_data);
                }
            }

            DB::commit();

            $this->deleteMultipleRedisKeys(["getAllAppByPlatformForAdmin", "getTestimonialData:$old_slug", "getFeedbackUrlByApp:$old_platform:$old_package_name"]);

            $response = Response::json(array('code' => 200, 'message' => 'App updated successfully.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (Exception $e) {
            Log::error("updateApp : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'update app.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
            DB::rollBack();
        }
        return $response;
    }

    public function deleteApp(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('app_id'), $request)) != '')
                return $response;

            $app_id = $request->app_id;

            $result = DB::select('SELECT image, webp_image FROM apps WHERE id = ?', [$app_id]);

            if ($result) {

                $image_name = $result[0]->image;
                $image_webp = $result[0]->webp_image;

                DB::beginTransaction();
                DB::delete('DELETE FROM apps WHERE id = ?', [$app_id]);
                DB::commit();

                DeleteFileInToS3::dispatch(config('constants.COMPRESSED_IMAGES_DIRECTORY'), $image_name, "compressed");
                DeleteFileInToS3::dispatch(config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY'), $image_webp, "webp_thumbnail");

                $this->deleteAllRedisKeys("getAllAppByPlatformForAdmin");

                $response = Response::json(array('code' => 200, 'message' => 'App deleted successfully.', 'cause' => '', 'data' => json_decode('{}')));

            } else {
                $response = Response::json(array('code' => 200, 'message' => 'App does not exist.', 'cause' => '', 'data' => json_decode('{}')));
            }

        } catch (Exception $e) {
            Log::error("deleteApp : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'delete app.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
            DB::rollBack();
        }
        return $response;
    }

    public function getAllAppByPlatformForAdmin(Request $request_body)
    {
        try {

            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('platform'), $request)) != '')
                return $response;

            $this->platform = $request->platform;

            $redis_result = Cache::remember("getAllAppByPlatformForAdmin:$this->platform", 300, function () {

                $where_condition = "";
                if ($this->platform) {
                    $where_condition = "WHERE am.platform = $this->platform";
                }

                $app_data = DB::select('SELECT
                                        am.id AS app_id,
                                        am.name,
                                        IF(am.image != "",CONCAT("' . config('constants.COMPRESSED_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN') . '",am.image),"") AS compressed_image,
                                        IF(am.webp_image != "",CONCAT("' . config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN') . '",am.webp_image),"") AS webp_thumbnail_image,
                                        IF(am.slug != "",CONCAT("' . config('constants.ACTIVATION_LINK_PATH') . '", "/", am.slug),"") AS slug_url,
                                        IF(am.platform = 1, "Android", IF(am.platform = 2, "iOS", "Web")) AS platform,
                                        am.package_name,
                                        am.is_active,
                                        am.is_paid,
                                        am.play_store_url,
                                        am.app_store_url,
                                        am.youtube_url,
                                        am.slug,
                                        am.price,
                                        am.main_question,
                                        am.custom_message
                                    FROM
                                        apps AS am
                                    ' . $where_condition . ' ');

                $questions = DB::select('SELECT
                                        aq.app_id AS app_id,
                                        aq.name AS app_questions
                                     FROM
                                         apps_question AS aq');

                return $redis_result = ['app_data' => $app_data, 'questions' => $questions];

            });

            $response = Response::json(array('code' => 200, 'message' => 'Apps fetched successfully.', 'cause' => '', 'data' => $redis_result));

        } catch (Exception $e) {
            Log::error("getAllAppByPlatformForAdmin : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . ' get all app by platform for admin.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function updateStatus(Request $request_body)
    {
        try {
            if ($request_body->is_active != null) {
                $where_condition = "is_active = $request_body->is_active WHERE id = $request_body->app_id";
            } else {
                $where_condition = "is_paid = $request_body->is_paid WHERE id = $request_body->app_id";
            }
            DB::update('UPDATE apps SET ' . $where_condition . ' ');
            $this->deleteMultipleRedisKeys(["getAllAppByPlatformForAdmin", "getTestimonialData:$request_body->slug", "getFeedbackUrlByApp:$request_body->platform:$request_body->package_name"]);

            $response = Response::json(array('code' => 200, 'message' => 'Apps status updated successfully.', 'cause' => '', 'data' => json_decode("{}")));

        } catch (Exception $e) {
            Log::error("updateStatus : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . ' update status.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    /* =========================================| App Testimonial |=========================================*/
    public function getTestimonialDetail(Request $request_body)
    {
        try {
            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('platform', 'date_range', 'app_id'), $request)) != '')
                return $response;

            $this->platform = $request->platform;
            $this->date_range = $request->date_range;
            $this->app_id = $request->app_id;
            $this->app_status = $request->app_status;
            $this->where_condition = "";

            if ($this->date_range) {
                $date_array = explode(' - ', $this->date_range);
                $this->from_date = $date_array[0];
                $this->to_date = $date_array[1];
                $this->where_condition .= " AND DATE(uf.updated_at) BETWEEN \"$this->from_date\" AND \"$this->to_date\" ";
            }

            if ($this->platform != 0) {
                $this->where_condition .= " AND ap.platform = $this->platform";
            }

            if ($this->app_id != 0) {
                $this->where_condition .= " AND uf.app_id = $this->app_id";
            }

            if ($this->app_status != 2) {
                $this->where_condition .= " AND uf.is_paid = $this->app_status";
            }

            $feedback_detail = DB::select('SELECT
                                                uf.id AS user_feedback_id,
                                                u.email AS email,
                                                uf.user_designation AS designation,
                                                uf.user_country AS country,
                                                uf.user_id AS user_id,
                                                uf.id AS user_feedback_id,
                                                uf.gift_id AS gift_id,
                                                uf.gift_code AS gift_code,
                                                uf.expired_date AS expired_date,
                                                uf.reward_type AS reward_type,
                                                uf.app_id AS app_id,
                                                IF(uf.webp_file != "",CONCAT("' . config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN') . '",uf.webp_file),"") AS video_thumbnail,
                                                IF(uf.file_name != "",CONCAT("' . config('constants.VIDEO_DIRECTORY_OF_DIGITAL_OCEAN') . '",uf.file_name),"") AS video,
                                                uf.is_paid AS is_paid,
                                                uf.feedback_type AS feedback_type,
                                                uf.user_name AS user_name,
                                                ap.name AS app_name,
                                                uf.user_info AS user_info,
                                                IF(ap.platform = 1, "Android", "IOS") AS platform,
                                                uf.created_at,
                                                uf.updated_at
                                            FROM
                                                users AS u
                                                INNER JOIN users_feedback AS uf ON uf.user_id = u.id
                                                INNER JOIN apps AS ap ON ap.id = uf.app_id
                                            WHERE
                                                u.is_active = 1 ' . $this->where_condition . '
                                            ORDER BY uf.updated_at DESC');

            $redis_result = $feedback_detail;

            $response = Response::json(array('code' => 200, 'message' => 'User feedback fetched successfully.', 'cause' => '', 'data' => $redis_result));

        } catch (Exception $e) {
            Log::error("getTestimonialDetail : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . ' User Feedback details.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function sendGiftMail(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('gift_id', 'gift_code'), $request)) != '')
                return $response;

            $after_paid_mail = config('constants.CONTENT_TYPE_OF_AFTER_PAID_MAIL');

            $mail_content = DB::select('SELECT
                                            md.subject AS subject,
                                            md.description AS description
                                       FROM
                                            mails_detail AS md
                                       WHERE md.content_type = ?', [$after_paid_mail]);

            $app_data = DB::select('SELECT
                                                name,
                                                IF(webp_image != "",CONCAT("' . config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN') . '",webp_image),"") AS webp_thumbnail_image,
                                                play_store_url,
                                                app_store_url,
                                                platform,
                                                price
                                               FROM apps
                                               WHERE id = ?', [$request->app_id]);

            $template = 'admin.users.mail.after-verification';
            $email = $request->email;
            $user_name = $request->user_name;
            $subject = str_replace("app_name", $app_data[0]->name, $mail_content[0]->subject);
            $description = str_replace("app_name", $app_data[0]->name, $mail_content[0]->description);
            $expiry_date = ($request->expiry_date != "") ? $request->expiry_date : NULL;
            $message_body = ['user_name' => $user_name, 'app_name' => $app_data[0]->name, 'price' => $app_data[0]->price, 'app_platform' => $app_data[0]->platform, 'app_logo' => $app_data[0]->webp_thumbnail_image, 'play_store_url' => $app_data[0]->play_store_url, 'app_store_url' => $app_data[0]->app_store_url, 'message' => $description, 'gift_id' => $request->gift_id, 'gift_code' => $request->gift_code, 'expiry_date' => $expiry_date];
            $api_name = 'sendGiftMail';
            $api_description = 'Send Gift mail.';
            $feedback_pending = config('constants.FEEDBACK_TYPE_OF_PENDING');
            $feedback_done = config('constants.FEEDBACK_TYPE_OF_DONE');
            $reward_custom = config('constants.REWARD_TYPE_OF_CUSTOM');
            $already_given = config('constants.FEEDBACK_TYPE_OF_ALREADY_GIVEN');

            $this->dispatch(new SendMail($email, $subject, $message_body, $template, $api_name, $api_description));

            DB::update('UPDATE users_feedback SET feedback_type = ?,reward_type = ?,gift_id = ?,gift_code = ?,expired_date = ? WHERE id = ?', [$feedback_done, $reward_custom, $request->gift_id, $request->gift_code, $expiry_date, $request->user_feedback_id]);

            DB::update('UPDATE users_feedback SET feedback_type = ? WHERE user_id = ? AND app_id = ? AND feedback_type = ?', [$already_given, $request->user_id, $request->app_id, $feedback_pending]);

            $response = Response::json(array('code' => 200, 'message' => 'Gift mail Send successfully.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (Exception $e) {
            Log::error("sendGiftMail : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'send gift mail.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function rejectGift(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            $feedback_reject = config('constants.FEEDBACK_TYPE_OF_REJECT');

            DB::update('UPDATE users_feedback SET feedback_type = ? WHERE id = ?', [$feedback_reject, $request->user_feedback_id]);

            $response = Response::json(array('code' => 200, 'message' => 'Gift rejected successfully.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (Exception $e) {
            Log::error("rejectGift : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'reject gift.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function updateRewardStatus(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            $reward_amazon = config('constants.REWARD_TYPE_OF_AMAZON');
            $feedback_done = config('constants.FEEDBACK_TYPE_OF_DONE');

            DB::update('UPDATE users_feedback SET reward_type = ?,feedback_type = ? WHERE id = ?', [$reward_amazon, $feedback_done, $request->user_feedback_id]);

            $response = Response::json(array('code' => 200, 'message' => 'Update reward type successfully.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (Exception $e) {
            Log::error("updateRewardStatus : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'update reward type.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function notifyUserViaMail(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('email', 'subject', 'description'), $request)) != '')
                return $response;

            $response = Response::json(array('code' => 200, 'message' => 'Mail send successfully.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (Exception $e) {
            Log::error("notifyUserViaMail : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'notify user via mail.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    /* =========================================| Mail Editor |=========================================*/
    public function updateMailContent(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('content_type', 'subject', 'description'), $request)) != '')
                return $response;

            DB::update('UPDATE mails_detail SET subject = ?,description = ? WHERE content_type = ? ', [$request->subject, $request->description, $request->content_type]);
            $this->deleteAllRedisKeys("getMailContent");

            $response = Response::json(array('code' => 200, 'message' => 'Mail updated successfully.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (Exception $e) {
            Log::error("updateMailContent : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'update mail content.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;

    }

    public function getMailContent()
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $redis_result = Cache::rememberForever("getMailContent", function () {

                return DB::select('SELECT
                                                md.id AS user_id,
                                                md.content_type AS content_type,
                                                md.subject AS subject,
                                                md.description AS description
                                            FROM
                                                mails_detail AS md');
            });

            $response = Response::json(array('code' => 200, 'message' => 'Mail fetched successfully.', 'cause' => '', 'data' => $redis_result));

        } catch (Exception $e) {
            Log::error("getMailContent : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get mail content.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;

    }

    /* =====================================| Redis Cache Menu |==============================================*/
    public function getRedisKeys()
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $redis_keys = Redis::keys(config("constants.REDIS_KEY") . ':*');

            $response = Response::json(array('code' => 200, 'message' => 'Redis keys fetched successfully.', 'cause' => '', 'data' => $redis_keys));
            $response->headers->set('Cache-Control', config('constants.RESPONSE_HEADER_CACHE'));

        } catch (Exception $e) {
            Log::error("getRedisKeys : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get redis-cache keys.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function deleteRedisKeys(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());

            if (($response = (new VerificationController())->validateRequiredArrayParameter(array('keys_list'), $request)) != '')
                return $response;

            $keys = $request->keys_list;
            Redis::del($keys);

            $response = Response::json(array('code' => 200, 'message' => 'Redis keys deleted successfully.', 'cause' => '', 'data' => json_decode('{}')));
            $response->headers->set('Cache-Control', config('constants.RESPONSE_HEADER_CACHE'));

        } catch (Exception $e) {
            Log::error("deleteRedisKeys : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'delete redis keys.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function getRedisKeyDetail(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());

            if (($response = (new VerificationController())->validateRequiredParameter(array('key'), $request)) != '')
                return $response;

            $key = $request->key;
            $key_detail = Redis::get($key);

            $result = ['keys_detail' => unserialize($key_detail)];

            $response = Response::json(array('code' => 200, 'message' => 'Redis key detail fetched successfully.', 'cause' => '', 'data' => $result));

        } catch (Exception $e) {
            Log::error("getRedisKeyDetail : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get redis-cache key detail.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function clearRedisCache()
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $result = Redis::flushAll();
            $response = Response::json(array('code' => 200, 'message' => 'Redis keys deleted successfully.', 'cause' => '', 'data' => $result));
            $response->headers->set('Cache-Control', config('constants.RESPONSE_HEADER_CACHE'));

        } catch (Exception $e) {
            Log::error("clearRedisCache : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get redis-cache key detail.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function deleteAllRedisKeysByKeyName(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());

            if (($response = (new VerificationController())->validateRequiredParam(array('key_name'), $request)) != '')
                return $response;

            $key_name = $request->key_name;

            $response = (new UserController())->deleteAllRedisKeys($key_name);

            $response = Response::json(array('code' => 200, 'message' => 'Redis keys deleted successfully.', 'cause' => '', 'data' => $response));
            $response->headers->set('Cache-Control', config('constants.RESPONSE_HEADER_CACHE'));

        } catch (Exception $e) {
            Log::error("deleteAllRedisKeysByKeyName : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'delete redis keys.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    /* =================================| Sub Functions |=============================*/
    public function deleteAllRedisKeys($key_name)
    {
        try {
            $is_success = Redis::del(array_merge(Redis::keys(config("constants.REDIS_KEY") . ":$key_name*"), ['']));
            return $is_success;
        } catch (Exception $e) {
            Log::error("deleteAllRedisKeys : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return 0;
        }
    }

    public function deleteMultipleRedisKeys($key_name)
    {
        try {
            foreach ($key_name as $i => $name) {
                Redis::del(array_merge(Redis::keys(config("constants.REDIS_KEY") . ":$name*"), ['']));
            }
            return 1;
        } catch (Exception $e) {
            Log::error("deleteMultipleRedisKeys : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return 0;
        }
    }

    /* =====================================| API for debugging purpose |==============================================*/
    public function getPhpInfo()
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            return $php_info = phpinfo();

        } catch (Exception $e) {
            Log::error("getPhpInfo : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get php_info.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    //Fetch table information from database (use for only debugging query issue)
    public function getDatabaseInfo(Request $request_body)
    {
        try {

            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('query'), $request)) != '')
                return $response;

            $query = $request->query;
            return DB::select("$query");

        } catch (Exception $e) {
            Log::error("getDatabaseInfo : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get database information.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function getConstants(Request $request_body)
    {
        try {

            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('variable_name'), $request)) != '')
                return $response;

            $variable_name = $request->variable_name;
            return config("constants.$variable_name");

        } catch (Exception $e) {
            Log::error("getConstants : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get constants.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    //Artisan commands (use for only debugging artisan commands)
    public function runArtisanCommands(Request $request_body)
    {
        try {

            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('command'), $request)) != '')
                return $response;

            $command = $request->command;
            $exitCode = Artisan::call($command);
            return $exitCode;

        } catch (Exception $e) {
            Log::error("runArtisanCommands : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'run artisan command.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function getAllFileListFromS3(Request $request_body)
    {
        try {

            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());

            $file_path = isset($request->file_path) ? $request->file_path : '';
            $dir_name = isset($request->dir_name) ? $request->dir_name : '';
            $disk = Storage::disk('s3');

            $all_files = $disk->allFiles($file_path);
            $all_dir = $disk->directories($dir_name);

            $response = Response::json(array('code' => 201, 'message' => 's3 file fetch successfully.', 'cause' => '', 'data' => ['all_files' => $all_files, 'all_dir' => $all_dir]));

        } catch (Exception $e) {
            Log::error("checkWriteFileInS3 : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => Config::get('constant.EXCEPTION_ERROR') . 'run artisan command.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function runExecCommands(Request $request_body)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::toUser($token);

            $request = json_decode($request_body->getContent());
            if (($response = (new VerificationController())->validateRequiredParameter(array('command', 'is_root_user'), $request)) != '')
                return $response;

            $command = $request->command;
            $is_root_user = $request->is_root_user;

            if ($is_root_user) {
                $result = RunCommandAsRoot::dispatch($command, 'runExecCommands');
            } else {
                $result = shell_exec($command);
            }

            $response = Response::json(array('code' => 201, 'message' => 'command runs successfully.', 'cause' => '', 'data' => $result));

        } catch (Exception $e) {
            Log::error("runExecCommands : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'run artisan command.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }
}
