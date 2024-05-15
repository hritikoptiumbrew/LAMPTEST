<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::view('/login', 'admin.authentication.login')->name('login');
    Route::view('/home', 'admin.home')->name('home');
    Route::view('/users', 'admin.users')->name('users');
    Route::view('/app-details', 'admin.app-details')->name('app-details');
    Route::view('/app-testimonials', 'admin.app-testimonials')->name('app-testimonials');
    Route::view('/mail-content-editor', 'admin.mail-content-editor')->name('mail-content-editor');
    Route::view('/redis-cache', 'admin.redis-cache')->name('redis-cache');
    Route::view('/settings', 'admin.settings')->name('settings');

});

//user route
Route::post('/uploadFeedback', [UserController::class, 'uploadFeedback']);
Route::view('/app/redirect', 'admin.app-redirection');

//chunk route
Route::post('/uploadChunkFile', [UserController::class, 'uploadChunkFile']);
Route::post('/uploadData', [UserController::class, 'uploadData']);
Route::post('/uploadDataV2', [UserController::class, 'uploadDataV2']);

Route::view('user-qr-details/{suid}', 'admin.user-qr-details')->name('user-qr-details');
Route::post('/getUserQrDetails', [UserController::class, 'getUserQrDetails']);


Route::view('/testimonial', 'admin.users.testimonial')->name('testimonial');
Route::view('/', 'landing-page')->name('landing-page');
Route::view('/terms-and-conditions', 'terms-conditions')->name('terms-and-conditions');
Route::get('/{slug}', [UserController::class, 'getTestimonialData']);

