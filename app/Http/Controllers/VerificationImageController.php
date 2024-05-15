<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class VerificationImageController extends Controller
{
    public function verifyImage($image_array = array())
    {
        try {
            if (!empty($image_array)) {

                $extension = $image_array->getMimeType();
                if (!($extension == "image/jpg" || $extension == "image/jpeg" || $extension == "image/png")) {
                    Log::error("verifyImage : The $extension extension is not allowed.");
                    return Response::json(array('code' => 201, 'message' => 'The ' . $extension . ' extension is not allowed.', 'cause' => '', 'data' => json_decode("{}")));
                }

                $image_size = $image_array->getSize();
                if ($image_size > 5242880) {
                    Log::error("verifyImage : Process failed because the file is too big : $image_size, Please reduce the size of the file and try again.");
                    return Response::json(array('code' => 413, 'message' => 'Process failed because the file is too big, Please reduce the size of the file and try again.', 'cause' => '', 'data' => json_decode("{}")));
                }
            }
        } catch (Exception $e) {
            Log::error("verifyImage : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
    }

    public function verifySampleImage($image_array = array())
    {
        try {
            if (!empty($image_array)) {

                $extension = $image_array->getMimeType();
                //dd($extension);
                if (!($extension == "image/jpg" || $extension == "image/jpeg" || $extension == "image/png")) {
                    Log::error("verifySampleImage : The $extension extension is not allowed.");
                    return Response::json(array('code' => 201, 'message' => 'The ' . $extension . ' extension is not allowed.', 'cause' => '', 'data' => json_decode("{}")));
                }

                $image_size = $image_array->getSize();
                if ($image_size > 5242880) {
                    Log::error("verifySampleImage : Process failed because the file is too big : $image_size, Please reduce the size of the file and try again.");
                    return Response::json(array('code' => 201, 'message' => 'Process failed because the file is too big, Please reduce the size of the file and try again.', 'cause' => '', 'data' => json_decode("{}")));
                }
            }
        } catch (Exception $e) {
            Log::error("verifySampleImage : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
    }

    public function generateName($image_array, $image_type)
    {
        try {
            if (!empty($image_array)) {
                return uniqid() . '_' . $image_type . '_' . time() . '.' . strtolower($image_array->getClientOriginalExtension());
            }
        } catch (Exception $e) {
            Log::error("generateName : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
        }
    }
}
