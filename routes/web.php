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

Route::get('/user', function () {
    return auth()->user();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vtoken', 'HomeController@verify')->name('vtoken');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin' ,'middleware' => ['auth:web' , 'checkAdmin']], function () {
    Route::get('panel', 'AdminController@index');

    Route::get('panel/checkout', 'AdminController@checkout');
    Route::post('panel/checkout', 'AdminController@getcheckout');

    Route::get('panel/activety', 'AdminController@activety');
    Route::post('panel/activety', 'AdminController@getactivety');

    Route::get('panel/control', 'AdminController@control');


    Route::get('panel/blog', 'AdminController@blog');
    Route::post('panel/blog', 'AdminController@setblog')->name('blog.store');

    Route::get('panel/ticket', 'AdminController@ticket');
    Route::post('panel/ticket', 'AdminController@setticket');

    Route::get('panel/gallery', 'AdminController@gallery');
    Route::post('panel/gallery', 'AdminController@setgallery');

});

Route::group(['namespace' => 'User', 'prefix' => 'user','middleware' => ['auth:web'] ], function () {
    Route::get('panel', 'UserController@index');

    Route::resource('panel/control', 'EventController');

    Route::resource('panel/income', 'IncomeController');

    Route::get('panel/active', 'ActivityController@active');

    Route::resource('panel/ticket', 'TicketController');
//    Route::post('panel/ticket', 'UserController@setticket');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
