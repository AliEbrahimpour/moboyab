<?php

use Illuminate\Http\Request;

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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


/**
 * APIs
 */
Route::group(array('prefix' => '/v1'), function () {
    Route::post('login', 'ApiController@login');
    Route::post('register', 'ApiController@register');
    Route::post('activation', 'ApiController@activation');
    Route::post('reset_active_code', 'ApiController@resetActiveCode');
    Route::post('send_request', 'ApiController@sendOneRequest');
    Route::post('change_pass', 'ApiController@changePass');
    Route::post('set_new_pass', 'ApiController@newPass');
    Route::post('send_location', 'ApiController@sendLocation');
    Route::post('get_location', 'ApiController@getLocation');
    Route::post('upload_image', 'ApiController@uploadImage');
    Route::post('set_backup_number', 'ApiController@setBackupNumber');
    Route::post('check_update', 'ApiController@checkUpdate');
    Route::post('add_device', 'ApiController@addDeviceId');
    Route::post('forget_pass', 'ApiController@forgetPass');
    Route::post('factor', 'ApiController@getFactor');
    Route::post('send_notif', 'ApiController@sendNotif');
    Route::post('get_delivery', 'ApiController@getDelivery');
    Route::post('dashboard', 'ApiController@getDashboard');

    Route::get('get_client_sms', 'ApiController@getClientSMS');
    Route::post('getNews', 'ApiController@getNews');

//    Route::middleware('jwt.auth')->post('addBackup', 'ApiController@addBackup');
//    Route::middleware('jwt.auth')->post('getBackup', 'ApiController@getBackup');
//    Route::middleware('jwt.auth')->post('setNewRevenues', 'ApiController@getRevenues');
//    Route::middleware('jwt.auth')->post('getMyRevenues', 'ApiController@revenues');
});


