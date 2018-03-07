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

//api
Route::group(['prefix' => 'api'], function () {
    //table1
    Route::get('/makeCodeImg', 'ApiController@uploadNumber');
    Route::get('/postUrl', 'ApiController@postUrl');

});












