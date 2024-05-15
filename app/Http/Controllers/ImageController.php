<?php

namespace App\Http\Controllers;

use Exception;
use FFMpeg;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    // get base url
    public function getBaseUrl()
    {
        return config('constants.ACTIVATION_LINK_PATH');
    }

    public function saveFileByPath($image_array, $img, $original_path, $dir_name)
    {
        try {
            $image_array->move($original_path, $img);
            //$path = $original_path . $img;
            //$this->saveImageDetails($path, $dir_name);

        } catch (Exception $e) {
            Log::error("saveFileByPath : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
    }

    public function saveCompressedImage($cover_img)
    {
        try {
            $original_path = config('constants.ORIGINAL_IMAGES_DIRECTORY') . $cover_img;
            $compressed_path = config('constants.COMPRESSED_IMAGES_DIRECTORY') . $cover_img;
            $img = Image::make($original_path);
            $img->save($compressed_path, 75);

            $original_img_size = filesize($original_path);
            $compress_img_size = filesize($compressed_path);

            if ($compress_img_size >= $original_img_size) {
                //save original image in Compress image
                unlink($compressed_path);
                copy($original_path, $compressed_path);
            }

            //$this->saveImageDetails($compressed_path, 'compressed');


        } catch (Exception $e) {
            Log::error("saveCompressedImage : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $dest1 = config('constants.ORIGINAL_IMAGES_DIRECTORY') . $cover_img;
            $dest2 = config('constants.COMPRESSED_IMAGES_DIRECTORY') . $cover_img;
            copy($dest1, $dest2);
        }
    }

    public function saveWebpOriginalImage($img)
    {
        try {

            $original_path = config('constants.ORIGINAL_IMAGES_DIRECTORY');
            $path = $original_path . $img;


            //convert image into .webp format
            $file_data = pathinfo(basename($path));
            $webp_name = $file_data['filename'];

            /*
             * -q Set image quality
             * -o Output file name
             */

            $webp_path = config('constants.IMAGE_BUCKET_WEBP_ORIGINAL_IMG_PATH') . $webp_name . '.webp';
            $org_path = config('constants.IMAGE_BUCKET_ORIGINAL_IMG_PATH') . $img;
            $quality = config('constants.QUALITY');
            $libwebp = config('constants.PATH_OF_CWEBP');

            $cmd = "$libwebp -q $quality $org_path -o $webp_path";

            if (config('constants.APP_ENV') != 'local') {
                $result = (!shell_exec($cmd));
            } else {
                $result = (!exec($cmd));
            }
            return $webp_name . '.webp';

        } catch (Exception $e) {
            Log::error("saveWebpOriginalImage : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
    }

    //image Analysis
    public function saveImageDetails($image_path, $image_directory)
    {
        try {
            //Log::info('file details:',pathinfo($image_path));
            $file_info = pathinfo($image_path);
            $name = $file_info['basename'];
            $type = $file_info['extension'];
            $width = Image::make($image_path)->width();
            $height = Image::make($image_path)->height();
            $size = filesize($image_path);
            //$size = $bytes/(1024 * 1024);
            //Log::info('file details:',[$name,$type,$height,$width,$size]);
            $pixel = 0;
            $create_at = date('Y-m-d H:i:s');
            DB::beginTransaction();

            DB::insert('INSERT INTO image_details
                            (name,directory_name,type,size,height,width,pixel,create_time)
                            values (?,?,?,?,?,?,?,?)',
                [$name, $image_directory, $type, $size, $height, $width, $pixel, $create_at]);

            DB::commit();
        } catch (Exception $e) {
            Log::error("saveImageDetails : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            DB::rollBack();
            return Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . ' save image details.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
    }

    //save webp thumbnail image
    public function saveWebpThumbnailImage($file_name, $original_path, $org_path)
    {
        try {
            $array = $this->getThumbnailWidthHeight($file_name, $original_path);
            $width = $array['width'];
            $height = $array['height'];

            $webp_name = pathinfo(basename($file_name))['filename'] . ".webp";
            $image_size = getimagesize($original_path);
            $org_img_height = $image_size[1];
            $org_img_width = $image_size[0];
            $width_orig = ($image_size[0] * 50) / 100;
            $height_orig = ($image_size[1] * 50) / 100;

            /*
             *  -q Set image quality
             *  -o Output file name
             *  -resize  Resize the image
             */
            $webp_path = config('constants.IMAGE_BUCKET_WEBP_THUMBNAIL_IMG_PATH') . $webp_name;
            $quality = config('constants.QUALITY');
            $libwebp = config('constants.PATH_OF_CWEBP');

            if ($width_orig < 200 or $height_orig < 200) {

                $cmd = "$libwebp -q $quality $org_path -resize $width $height -o $webp_path";
                if (config('constants.APP_ENV') != 'local') {
                    //For Linux
                    $result = (!shell_exec($cmd));
                } else {
                    // For windows
                    $result = (!exec($cmd));
                }

                return array('height' => $height, 'width' => $width, 'org_img_height' => $org_img_height, 'org_img_width' => $org_img_width, 'webp_file_name' => $webp_name);

            } else {

                $cmd = "$libwebp -q $quality $org_path -resize $width_orig $height_orig -o $webp_path";
                if (config('constants.APP_ENV') != 'local') {
                    //For Linux
                    $result = (!shell_exec($cmd));
                } else {
                    // For windows
                    $result = (!exec($cmd));
                }
                return array('height' => $height_orig, 'width' => $width_orig, 'org_img_height' => $org_img_height, 'org_img_width' => $org_img_width, 'webp_file_name' => $webp_name);
            }

        } catch (Exception $e) {
            Log::error("saveWebpThumbnailImage : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return array('height' => 0, 'width' => 0, 'org_img_height' => 0, 'org_img_width' => 0, 'webp_file_name' => NULL);
        }
    }

    public function saveWebpThumbnailVideo($file_name, $original_path, $org_path)
    {
        try {
            $array = $this->getThumbnailWidthHeight($file_name, $original_path);
            $width = $array['width'];
            $height = $array['height'];
            $webp_name = pathinfo(basename($file_name))['filename'] . ".webp";
            $webp_path = config('constants.IMAGE_BUCKET_WEBP_THUMBNAIL_IMG_PATH') . $webp_name;

            $ffmpeg = Config('constants.FFMPEG_PATH');
            $cmd = "$ffmpeg -i $org_path -ss 00:00:01.000 -vf scale=$width:$height -vframes 1 $webp_path";
            if (config('constants.APP_ENV') != 'local') {
                //For Linux
                $result = (!shell_exec($cmd));
            } else {
                // For windows
                $result = (!exec($cmd));
            }
            return array('height' => $height, 'width' => $width, 'webp_file_name' => $webp_name);

        } catch (Exception $e) {
            Log::error("saveWebpThumbnailVideo : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return array('height' => 0, 'width' => 0, 'webp_file_name' => NULL);
        }
    }

    //get height-width of thumbnail image
    public function getThumbnailWidthHeight($file_name, $original_path)
    {

        $image_size = getimagesize($original_path);

        if ($image_size == false) {
            $ffprobe = FFMpeg\FFProbe::create();
            $video_dimensions = $ffprobe
                ->streams($original_path)
                ->videos()
                ->first()
                ->getDimensions();
            $width = $video_dimensions->getWidth();
            $height = $video_dimensions->getHeight();
        }

        $width_orig = isset($image_size[0]) ? $image_size[0] : $width;
        $height_orig = isset($image_size[1]) ? $image_size[1] : $height;

        return array('width' => $width_orig, 'height' => $height_orig);
    }

    // unlinkFileFromLocalStorage
    public function unlinkFileFromLocalStorage($file, $path)
    {
        try {

            $original_image_path = $path . $file;

            if (($is_exist = ($this->checkFileExist($original_image_path)) != 0)) {
                unlink($original_image_path);
            } else {
                Log::info('unlinkFileFromLocalStorage : file not exist ', [$original_image_path]);
            }

        } catch (Exception $e) {
            Log::error("unlinkFileFromLocalStorage : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
    }

    public function deleteObjectFromS3($file, $path)
    {
        try {
            $aws_bucket = config('constants.AWS_BUCKET_ROOT_DIR');
            $disk = Storage::disk('s3');
            $resource_targetFile = "$aws_bucket/$path/" . $file;

            if ($disk->exists($resource_targetFile)) {
                $disk->delete($resource_targetFile);
            }

        } catch (Exception $e) {
            Log::error("deleteObjectFromS3 : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
    }

    public function deleteFileByPath($file_name, $original_path, $dir_name)
    {
        try {

            if (config('constants.STORAGE') === 'S3_BUCKET') {
                $this->deleteObjectFromS3($file_name, $dir_name);
            } else {
                $this->unlinkFileFromLocalStorage($file_name, $original_path);
            }

        } catch (Exception $e) {
            Log::error("deleteFileByPath : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
    }

    public function checkFileExist($file_path)
    {
        try {

            if (file_exists($file_path)) {
                $response = 1;
            } else {
                $response = 0;
            }

        } catch (Exception $e) {
            Log::error("checkFileExist Exception :", ['Error : ' => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            $response = 0;
        }
        return $response;
    }

    public function saveFileToS3ByPath($file_path, $file_name, $folder_name, $preview_image = '')
    {
        try {
            $aws_bucket = config('constants.AWS_BUCKET_ROOT_DIR');
            $disk = Storage::disk('s3');

            if (($is_exist = ($this->checkFileExist($file_path . $file_name)) != 0)) {
                $resource_targetFile = "$aws_bucket/$folder_name/" . $file_name;
                $disk->put($resource_targetFile, file_get_contents($file_path . $file_name));

                ($preview_image) ? $this->saveImageTrackers($file_name, $folder_name, $preview_image) : "";

                unlink($file_path . $file_name);

            } else {
                Log::info('saveFileToS3ByPath : file not exist ', [$file_path . $file_name]);
            }

        } catch (Exception $e) {
            Log::info('saveFileToS3ByPath : ', ['Exception' => $e->getMessage(), '\nTraceAsString' => $e->getTraceAsString()]);
        }

    }

    public function saveImageTrackers($image_name, $image_directory, $preview_image)
    {
        try {

            DB::beginTransaction();

            DB::insert('INSERT INTO image_track_master
                            (preview_image, name, directory_name)
                            VALUES (?, ?, ?)',
                [$preview_image, $image_name, $image_directory]);

            DB::commit();

        } catch (Exception $e) {
            Log::error("saveImageTrackers : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            DB::rollBack();
            return Response::json(array('code' => 201, 'message' => config('constants.EXCEPTION_ERROR') . ' save image trackers.', 'cause' => $e->getMessage(), 'data' => json_decode("{}")));
        }
    }
}
