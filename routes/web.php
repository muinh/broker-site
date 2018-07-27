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
//Route::group(['prefix' => 'admin'], function (){
//    Route::get('/', 'Admin\IndexController@index');
//});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::post('login', ['uses' => 'Admin\IndexController@postLogin', 'as' => 'postlogin']);
});

Route::get('check/access', 'IndexController@isAccessAllowed');
Route::get('autoLogin', 'IndexController@autoLogin');
Route::post('autoLogin', 'IndexController@postAutoLogin');
Route::post('depositReceived', 'IndexController@deposit');
Route::get('{slug?}', 'IndexController@index')->where('slug', '.*');
