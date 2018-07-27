<?php

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

require __DIR__.'/../app/Platforms/Bx8/routing.php';

Route::get('/page/{slug}', 'PageController@view')->where(['slug' => '[\W\w]+']);
Route::get('/menu/{name}', 'MenuController@get')->where(['name' => '[\W\w]+']);
Route::post('/call', 'IndexController@scheduleForm');
Route::post('/upload-docs', 'IndexController@uploadForm');
Route::get('/captcha', 'IndexController@captcha');
