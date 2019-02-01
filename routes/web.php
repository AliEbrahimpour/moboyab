<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('panel', 'AdminController@index');

    Route::get('panel/checkout', 'AdminController@checkout');
    Route::post('panel/checkout', 'AdminController@getcheckout');

    Route::get('panel/activety', 'AdminController@activety');
    Route::post('panel/activety', 'AdminController@getactivety');

    Route::get('panel/blog', 'AdminController@blog');
    Route::post('panel/blog', 'AdminController@setblog')->name('blog.store');

//    Route::get('panel/tickets-admin', 'AdminController@ticket');
//    Route::post('panel/ticket', 'AdminController@setticket');

    Route::get('panel/gallery', 'AdminController@gallery');
    Route::post('panel/gallery', 'AdminController@setgallery');

});

Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {
    Route::get('panel', 'UserController@index');

    Route::get('panel/control', 'UserController@control');
    Route::post('panel/control', 'UserController@setevent');

    Route::get('panel/income', 'UserController@income');
    Route::post('panel/income', 'UserController@setincome');

    Route::get('panel/active', 'UserController@active');
    Route::post('panel/active', 'UserController@setactive');

//    Route::get('panel/tickets', 'UserController@ticket');
//    Route::post('panel/ticket', 'UserController@setticket');

});
