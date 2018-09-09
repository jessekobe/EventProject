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
Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['middleware' => ['api','cors'],'prefix' => 'api'], function () {
    Route::post('register', 'TokenAuthController@register');
    Route::post('login', 'TokenAuthController@authenticate');
    Route::group(['middleware' => 'jwt.auth'], function () {
    	Route::get('authenticate/user', 'TokenAuthController@getAuthenticatedUser');
    	Route::resource('todo', 'TodoController');
    	Route::resource('table', 'TableController');
    	Route::resource('party', 'PartyController');
    	Route::resource('product', 'ProductController');
    	Route::resource('segment', 'SegmentController');
    	Route::resource('order', 'OrderController');
    	Route::resource('report', 'ReportController');
    });
});