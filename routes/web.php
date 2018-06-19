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

Route::get('/', '\App\Controllers\HomeController@index');

Route::get('home', '\App\Controllers\HomeController@index');

Route::get('news', '\App\Controllers\NewsController@index');

Route::get('news/{id}', '\App\Controllers\NewsController@index');

Route::get('events', '\App\Controllers\EventsController@index');

Route::get('/events/{id}', function ($id) {
    return 'Events! - ' . $id;
});

Route::get('tracking', '\App\Controllers\TrackingController@index');

Route::post('tracking', '\App\Controllers\TrackingController@Store');

