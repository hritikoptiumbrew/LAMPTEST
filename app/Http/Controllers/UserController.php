<?php

namespace App\Http\Controllers;

use App\Jobs\SendFeedbackMailJob;
use App\Jobs\SendMail;
use App\Jobs\UploadFileInToS3;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\Response;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class UserController extends Controller
{
    /*
    Purpose : Dynamic getting data for user feedback section
    Description : This method compulsory take 1 argument
    Return : return view file and put dynamic data if success otherwise error with specific status code
    */
    public function getTestimonialData($slug)
    {
        try {
            $redis_result = Cache::rememberforever("getTestimonialData:$slug", function () use ($slug) {

                $app_data = DB::select('SELECT
                                            a.id AS app_id,
                                            a.name AS app_name,
                                            a.price AS price,
                                            a.youtube_url AS youtube_url,
                                            a.is_paid AS is_paid,
                                            a.platform AS platform,
                                            IF(a.image != "",CONCAT("' . config('constants.CDN_PATH_FOR_BLADE_FILE') . 'compressed/",a.image),"") AS preview_image,
                                            a.main_question AS main_question,
                                            a.custom_message AS custom_message
                                       FROM
                                            apps AS a
                                       WHERE
                                            a.is_active = 1 AND
                                            a.slug = ?', [$slug]);

                if ($app_data && $app_data[0]->app_id) {
                    $app_data[0]->apps_question_details = DB::select('SELECT name FROM apps_question WHERE app_id = ?', [$app_data[0]->app_id]);
                    $app_data[0]->header_image = Config::get('constants.CDN_PATH_FOR_BLADE_FILE')."video.jpg";
                    return $app_data;
                } else {
                    return NULL;
                }
            });
            if ($redis_result) {
                return view('admin.users.testimonial', ['data' => $redis_result]);
            } else {
                return view('errors.404');
            }

        } catch (Exception $e) {
            Log::error("getTestimonialData : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return view('errors.404');
        }
    }

    /* =========================================| Upload single File |=========================================*/
    public function uploadFeedback(Request $request_body)
    {
        try {
            $request = json_decode($request_body->input('request_body'));
            if (($response = (new VerificationController())->validateRequiredParameter(array('app_id', 'name', 'email', 'is_paid', 'designation', 'country'), $request)) != '')
                return $response;

            if (!$request_body->hasFile('file'))
                return Response::json(array('code' => 201, 'message' => 'Required field File is missing or empty.', 'cause' => '', 'data' => json_decode("{}")));

            $app_id = $request->app_id;
            $name = substr($request->name, 0, 50);
            $email = $request->email;
            $is_paid = $request->is_paid;
            $password = Hash::make($email);
            $designation = substr($request->designation, 0, 50);
            $country = $request->country;
            $video_array = Input::file('file');
            $original_path = config('constants.VIDEO_DIRECTORY');
            $webp_thumbnail_path = config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY');
            $org_path = config('constants.IMAGE_BUCKET_ORIGINAL_VIDEO_PATH');

            if ($response = (new VerificationController())->verifyVideo($video_array))
                return $response;

            // generate unique name for video
            $video_file = (new VerificationImageController())->generateName($video_array, 'user_feedback');

            (new ImageController())->saveFileByPath($video_array, $video_file, $original_path, "original");

            //(new ImageController())->saveCompressedImage($app_logo);
            $dimension = (new ImageController())->saveWebpThumbnailVideo($video_file, $original_path . $video_file, $org_path . $video_file);

            if (config('constants.STORAGE') == 'S3_BUCKET') {
                UploadFileInToS3::dispatch($original_path, $video_file, "video", '');
                UploadFileInToS3::dispatch($webp_thumbnail_path, $dimension['webp_file_name'], "webp_thumbnail", '');
            }

            $users = ['app_id' => $app_id, 'email' => $email, 'password' => $password];

            DB::beginTransaction();
            $exist_user = DB::select('SELECT id FROM users WHERE email = ?', [$email]);

            if ($exist_user == NULL) {
                $user_id = DB::table('users')->insertGetId($users);

            } else {
                $user_id = $exist_user[0]->id;
                $rewarded_user = DB::select('SELECT feedback_type FROM users_feedback WHERE user_id = ? AND app_id = ? AND feedback_type = ?', [$exist_user[0]->id, $app_id, 1]);
            }

            $feedback_data = ['user_id' => $user_id, 'user_name' => $name, 'user_designation' => $designation, 'user_country' => $country, 'app_id' => $app_id, 'file_name' => $video_file, 'webp_file' => $dimension['webp_file_name'], 'is_paid' => $is_paid, 'feedback_type' => isset($rewarded_user[0]->feedback_type) ? $rewarded_user[0]->feedback_type : 1];
            DB::table('users_feedback')->insert($feedback_data);
            DB::commit();

            $app_data = DB::select('SELECT
                                                name,
                                                IF(webp_image != "",CONCAT("' . config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN') . '",webp_image),"") AS webp_thumbnail_image
                                               FROM apps
                                               WHERE id = ?', [$app_id]);

            if ($is_paid == 0) {
                $content_type = config('constants.CONTENT_TYPE_OF_FREE_MAIL');
                $mail_data = DB::select('SELECT subject,description FROM mails_detail WHERE content_type = ?', [$content_type]);
                $template = 'admin.users.mail.free-mail';
                $subject = $mail_data[0]->subject;
                $message_body = array(
                    'message' => $mail_data[0]->description,
                    'user_name' => $name,
                    'app_name' => $app_data[0]->name,
                    'app_logo' => $app_data[0]->webp_thumbnail_image
                );

            } else {
                $content_type = config('constants.CONTENT_TYPE_OF_BEFORE_PAID_MAIL');
                $mail_data = DB::select('SELECT subject,description FROM mails_detail WHERE content_type = ?', [$content_type]);
                $template = 'admin.users.mail.before-verification-mail';
                $subject = $mail_data[0]->subject;
                $message_body = array(
                    'message' => $mail_data[0]->description,
                    'user_name' => $name,
                    'app_name' => $app_data[0]->name,
                    'app_logo' => $app_data[0]->webp_thumbnail_image
                );

            }
            $api_name = 'uploadFeedback';
            $api_description = 'App feedback mail.';

            $this->dispatch(new SendMail($email, $subject, $message_body, $template, $api_name, $api_description));

            (new AdminController())->deleteAllRedisKeys("getAllAppByPlatformForAdmin");
            //(new ImageController())->unlinkFileFromLocalStorage($video_file, config('constants.VIDEO_DIRECTORY'));

            $response = Response::json(array('code' => 200, 'message' => 'App feedback added successfully.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (Exception $e) {
            Log::error("uploadFeedback : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'upload feedback.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
            DB::rollBack();
        }
        return $response;
    }

    /* =========================================| Chunking file uploading |=========================================*/
    public function uploadChunkFile(Request $request_body)
    {
        try {
            if (!$request_body->hasFile('file'))
                return Response::json(array('code' => 201, 'message' => 'Required field File is missing or empty.', 'cause' => '', 'data' => json_decode("{}")));
            //create the file receiver
            $receiver = new FileReceiver("file", $request_body, HandlerFactory::classFromRequest($request_body));

            // check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }
            // receive the file
            $save = $receiver->receive();

            // check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                // save the file and return any response you need, current example uses `move` function. If you are
                // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
                return $this->saveFile($save->getFile());
            }
            // we are in chunk mode, lets send the current progress
            $handler = $save->handler();
            return response()->json([
                "done" => $handler->getPercentageDone(),
                'status' => true
            ]);
        } catch (Exception $e) {
            Log::error("uploadChunkFile : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'upload feedback.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
            DB::rollBack();
        }
        return $response;
    }

    public function saveFile(UploadedFile $file)
    {
        try {

            //if ($response = (new VerificationController())->verifyVideo($file))
            //    return $response;

            // generate unique name for video
            $video_file = (new VerificationImageController())->generateName($file, 'user_feedback');
            $original_path = config('constants.VIDEO_DIRECTORY');
            $webp_thumbnail_path = config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY');
            $org_path = config('constants.IMAGE_BUCKET_ORIGINAL_VIDEO_PATH');
            // move the file name
            $file->move($original_path, $video_file);

            //(new ImageController())->saveCompressedImage($app_logo);
            $dimension = (new ImageController())->saveWebpThumbnailVideo($video_file, $original_path . $video_file, $org_path . $video_file);

            if (config('constants.STORAGE') == 'S3_BUCKET') {
                UploadFileInToS3::dispatch($original_path, $video_file, "video", '');
                UploadFileInToS3::dispatch($webp_thumbnail_path, $dimension['webp_file_name'], "webp_thumbnail", '');
            }

            $response = response()->json([
                'path' => $original_path,
                'name' => $video_file,
                'webp_thumbnail' => $dimension['webp_file_name']
            ]);

        } catch (Exception $e) {
            Log::error("saveFile : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'save file.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function uploadData(Request $request_body)
    {
        try {
            $request = json_decode($request_body->input('request_body'));
            if (($response = (new VerificationController())->validateRequiredParameter(array('app_id', 'name', 'email', 'is_paid', 'designation', 'country', 'file_name', 'webp_thumbnail'), $request)) != '')
                return $response;

            $app_id = $request->app_id;
            $user_name = substr($request->name, 0, 50);
            $email = $request->email;
            $is_paid = $request->is_paid;
            $password = Hash::make($email);
            $user_designation = substr($request->designation, 0, 50);
            $user_country = $request->country;
            $file_name = $request->file_name;
            $webp_file = $request->webp_thumbnail;
            $app_platform = $request->app_platform;
            $user_info = json_encode($request->user_info);

            $users = ['app_id' => $app_id, 'email' => $email, 'password' => $password];

            DB::beginTransaction();
            $exist_user = DB::select('SELECT id FROM users WHERE email = ?', [$email]);

            if ($exist_user == NULL) {
                $user_id = DB::table('users')->insertGetId($users);

            } else {
                $user_id = $exist_user[0]->id;
                $feedback_type_done = config('constants.FEEDBACK_TYPE_OF_DONE');
                $rewarded_user = DB::select('SELECT feedback_type FROM users_feedback WHERE user_id = ? AND app_id = ? AND feedback_type = ?', [$exist_user[0]->id, $app_id, $feedback_type_done]);
            }
            $feedback_type_pending = config('constants.FEEDBACK_TYPE_OF_PENDING');
            $feedback_already_given = config('constants.FEEDBACK_TYPE_OF_ALREADY_GIVEN');
            $feedback_data = ['user_id' => $user_id, 'user_name' => $user_name, 'user_designation' => $user_designation, 'user_country' => $user_country, 'app_id' => $app_id, 'is_paid' => $is_paid, 'file_name' => $file_name, 'webp_file' => $webp_file, 'feedback_type' => isset($rewarded_user[0]->feedback_type) ? $feedback_already_given : $feedback_type_pending, 'user_info' => $user_info];
            DB::table('users_feedback')->insert($feedback_data);
            DB::commit();

            $app_data = DB::select('SELECT
                                                name,
                                                IF(webp_image != "",CONCAT("' . config('constants.WEBP_THUMBNAIL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN') . '",webp_image),"") AS webp_thumbnail_image,
                                                play_store_url,
                                                app_store_url
                                               FROM apps
                                               WHERE id = ?', [$app_id]);

            if ($is_paid == 0) {
                $content_type = config('constants.CONTENT_TYPE_OF_FREE_MAIL');
                $mail_data = DB::select('SELECT subject,description FROM mails_detail WHERE content_type = ?', [$content_type]);
                $template = 'admin.users.mail.free-mail';
                $subject = $mail_data[0]->subject;
                $message_body = array(
                    'message' => $mail_data[0]->description,
                    'user_name' => $user_name,
                    'app_name' => $app_data[0]->name,
                    'app_platform' => $app_platform,
                    'app_logo' => $app_data[0]->webp_thumbnail_image,
                    'play_store_url' => $app_data[0]->play_store_url,
                    'app_store_url' => $app_data[0]->app_store_url
                );

            } else {
                $content_type = config('constants.CONTENT_TYPE_OF_BEFORE_PAID_MAIL');
                $mail_data = DB::select('SELECT subject,description FROM mails_detail WHERE content_type = ?', [$content_type]);
                $template = 'admin.users.mail.before-verification-mail';
                $subject = $mail_data[0]->subject;
                $message_body = array(
                    'message' => $mail_data[0]->description,
                    'user_name' => $user_name,
                    'app_name' => $app_data[0]->name,
                    'app_platform' => $app_platform,
                    'app_logo' => $app_data[0]->webp_thumbnail_image,
                    'play_store_url' => $app_data[0]->play_store_url,
                    'app_store_url' => $app_data[0]->app_store_url
                );

            }
            $api_name = 'uploadFeedback';
            $api_description = 'App feedback mail.';

            $this->dispatch(new SendFeedbackMailJob($email, $subject, $message_body, $template, $api_name, $api_description));

            (new AdminController())->deleteAllRedisKeys("getAllAppByPlatformForAdmin");
            //(new ImageController())->unlinkFileFromLocalStorage($video_file, config('constants.VIDEO_DIRECTORY'));

            $response = Response::json(array('code' => 200, 'message' => 'App feedback added successfully.', 'cause' => '', 'data' => json_decode('{}')));

        } catch (Exception $e) {
            Log::error("uploadData : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'upload data.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
            DB::rollBack();
        }
        return $response;
    }

    /* =========================================| Get qr detail for user |=========================================*/

    public function getUserQrDetails(Request $request_body)
    {
        try {
            $request = json_decode($request_body->getContent());
            $this->user_id = $request->suid;
            $qr_path = config('constants.QR_API_PATH');
            $response = Http::get("$qr_path/getUserQrDetails/$request->suid");
            if ($response->clientError() == true) {
                $response = Response::json(array('code' => 201, 'message' => 'Something went wrong', 'data' => json_decode("{}")));
            }
            $response = Response::json(array('code' => 200, 'message' => 'QR details fetched successfully.', 'cause' => '', 'data' => $response->object()->data));
        } catch (Exception $e) {
            Log::error("getUserQrDetails : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'get user qr detail.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    /* =========================================|  Error reporting api |=========================================*/

    public function errorReportingViaMail()
    {
        try {
            $template = 'simple';
            $email = config('constants.ADMIN_EMAIL_ID');
            $subject = 'Email failed';
            $api_name = 'errorReportingViaMail';
            $api_description = '';
            $message_body = array(
                'message' => 'The size of the video uploaded by the user exceeded  100 MB',
                'user_name' => 'Admin'
            );
            $this->dispatch(new SendMail($email, $subject, $message_body, $template, $api_name, $api_description));
            $response = true;
        } catch (Exception $e) {
            Log::error("errorReportingViaMail : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'error reporting mail.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }


    /* =========================================| Call api from app |=========================================*/

    /**
     * @OA\Post(
     * path="/getFeedbackUrlByApp",
     * summary="Get feedback url by app.",
     * description="Get feedback url by app.",
     * operationId="getFeedbackUrlByApp",
     * tags={"User"},
     * security={ {"bearerAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass users data",
     *    @OA\JsonContent(
     *       required={"platform","package_name"},
     *       @OA\Property(property="platform",  type="integer", example=1, description=""),
     *       @OA\Property(property="package_name",  type="string", example="com.videomaker.postermaker", description=""),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Fonts fetched successfully.",
     *    @OA\JsonContent(
     *       @OA\Property(property="code", type="integer", example=200),
     *       @OA\Property(property="message", type="string", example="feedback url fetch successfully."),
     *       @OA\Property(property="cause", type="string", example=""),
     *       @OA\Property(property="data", type="object",
     *          @OA\Property(property="slug_url", type="string", example="http://192.168.0.109/ob_testimonial/public/VideoAd-Maker"),
     *          @OA\Property(property="is_paid", type="integer", example=0),
     *          @OA\Property(property="price", type="integer", example=25),
     *       ),
     *    )
     *  ),
     *  @OA\Response(
     *    response=201,
     *    description="OB TESTIMONIAL is unable to feedback url by app.",
     *    @OA\JsonContent(
     *       @OA\Property(property="code", type="integer", example=201),
     *       @OA\Property(property="message", type="string", example="OB CDS is unable to feedback url by app."),
     *       @OA\Property(property="cause", type="string", example=""),
     *       @OA\Property(property="data", type="object", example="{}"),
     *    )
     *  )
     * )
     */
    public function getFeedbackUrlByApp(Request $request_body)
    {
        try {
            $request = json_decode($request_body->getContent());

            if (($response = (new VerificationController())->validateRequiredParameter(array('platform', 'package_name'), $request)) != '')
                return $response;

            $this->platform = $request->platform;
            $this->package_name = $request->package_name;

            $redis_result = Cache::rememberforever("getFeedbackUrlByApp:$this->platform:$this->package_name", function () {

                $slug_detail = DB::select('SELECT
                                            CONCAT("' . config('constants.ACTIVATION_LINK_PATH') . '", "/", a.slug) AS slug_url,
                                            a.is_paid,
                                            a.price
                                        FROM
                                            apps AS a
                                        WHERE
                                            a.is_active = 1 AND
                                            a.package_name = ? AND
                                            a.platform = ?',
                    [$this->package_name, $this->platform]);

                if ($slug_detail && $slug_detail[0]) {
                    return $slug_detail[0];
                } else {
                    return NULL;
                }
            });

            $response = Response::json(array('code' => 200, 'message' => 'feedback url fetch successfully.', 'cause' => '', 'data' => $redis_result));

        } catch (Exception $e) {
            Log::error("getFeedbackUrlByApp : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'feedback url by app.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
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
                Redis::del(array_merge(Redis::keys(Config::get("constant.REDIS_KEY") . ":$name*"), ['']));
            }
            return 1;

        } catch (Exception $e) {
            Log::error("deleteMultipleRedisKeys : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return 0;
        }
    }

    /* =================================| Debug API |=============================*/
    public function monitorTransferStartApi()
    {
        try {
            $response = Response::json(array('code' => 200, 'message' => 'Test Successful.', 'cause' => '', 'data' => json_decode("{}")));

        } catch (Exception $e) {
            Log::error("monitorTransferStartApi : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'monitor transfer start api.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }

    public function debugApi()
    {
        try {
            $result = exec('whoami') . " lisimenu " . php_sapi_name();
            Log::info($result);

            $response = Response::json(array('code' => 200, 'message' => 'File uploaded Successfully.', 'cause' => '', 'data' => $result));

        } catch (Exception $e) {
            Log::error("debugApi : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . 'test debug API.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
        return $response;
    }
}
