<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Google2faController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('logs/{user_name}/{password}', [LogViewerController::class, 'index'])->where(['user_name' => config('constants.LOG_USERNAME'), 'password' => config('constants.LOG_PASSWORD')]);


Route::post('doLoginForGuest', [LoginController::class, 'doLoginForGuest']);
Route::post('userSignIn', [LoginController::class, 'userSignIn']);
Route::post('doLoginForAdmin', [LoginController::class, 'doLoginForAdmin']);
Route::post('verify2faOPT', [Google2faController::class, 'verify2faOPT']);


//AdminController API
Route::group(['prefix' => '', 'middleware' => ['ability:admin,admin_permission']], function () {

    //Application
    Route::post('addApp', [AdminController::class, 'addApp']);
    Route::post('updateApp', [AdminController::class, 'updateApp']);
    Route::post('deleteApp', [AdminController::class, 'deleteApp']);
    Route::post('updateStatus', [AdminController::class, 'updateStatus']);

    //Mail Editor
    Route::post('updateMailContent', [AdminController::class, 'updateMailContent']);
    Route::post('sendGiftMail', [AdminController::class, 'sendGiftMail']);
    Route::post('rejectGift', [AdminController::class, 'rejectGift']);
    Route::post('updateRewardStatus', [AdminController::class, 'updateRewardStatus']);
    Route::post('notifyUserViaMail', [AdminController::class, 'notifyUserViaMail']);

    //Redis
    Route::post('getRedisKeys', [AdminController::class, 'getRedisKeys']);
    Route::post('deleteRedisKeys', [AdminController::class, 'deleteRedisKeys']);
    Route::post('getRedisKeyDetail', [AdminController::class, 'getRedisKeyDetail']);
    Route::post('clearRedisCache', [AdminController::class, 'clearRedisCache']);
    Route::post('deleteAllRedisKeysByKeyName', [AdminController::class, 'deleteAllRedisKeysByKeyName']);

    Route::post('enable2faByAdmin', [Google2faController::class, 'enable2faByAdmin']);
    Route::post('disable2faByAdmin', [Google2faController::class, 'disable2faByAdmin']);

    Route::post('changePassword', [LoginController::class, 'changePassword']);

});

//AdminController API
Route::group(['prefix' => '', 'middleware' => ['ability:admin|sub_admin,admin_permission|sub_admin_permission']], function () {

    //Get report Data
    Route::post('getAllReportByAdmin', [AdminController::class, 'getAllReportByAdmin']);

    //Get Application Data
    Route::post('getAllAppByPlatformForAdmin', [AdminController::class, 'getAllAppByPlatformForAdmin']);

    //Get User Data
    Route::post('getAllUsersByAdmin', [AdminController::class, 'getAllUsersByAdmin']);

    //Get Testimonial Data
    Route::post('getTestimonialDetail', [AdminController::class, 'getTestimonialDetail']);

    //Get Mail Content Data
    Route::post('getMailContent', [AdminController::class, 'getMailContent']);

});

//AdminController API & UserController API
Route::group(['prefix' => '', 'middleware' => ['ability:admin|user|sub_admin,admin_permission|user_permission|sub_admin_permission']], function () {

    Route::post('doLogout', [LoginController::class, 'doLogout']);

});

Route::post('errorReportingViaMail', [UserController::class, 'errorReportingViaMail']);
Route::post('getFeedbackUrlByApp', [UserController::class, 'getFeedbackUrlByApp']);
Route::post('getDatabaseInfo', [AdminController::class, 'getDatabaseInfo']);
Route::post('getConstants', [AdminController::class, 'getConstants']);
Route::post('runArtisanCommands', [AdminController::class, 'runArtisanCommands']);
Route::post('getAllFileListFromS3', [AdminController::class, 'getAllFileListFromS3']);
Route::post('runExecCommands', [AdminController::class, 'runExecCommands']);
Route::post('getPhpInfo', [AdminController::class, 'getPhpInfo']);
Route::post('deleteAllRedisKeysByKeyName', [AdminController::class, 'deleteAllRedisKeysByKeyName']);

Route::post('monitorTransferStartApi', [UserController::class, 'monitorTransferStartApi']);
Route::post('debugApi', [UserController::class, 'debugApi']);
