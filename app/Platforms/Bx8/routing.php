<?php

Route::group(['middleware' => 'throttle:60'], function () {
    Route::get('geo', 'bx8\PlatformController@countries');
    Route::get('countries', 'bx8\PlatformController@getCountries');
    Route::post('login', 'bx8\PlatformController@login');
    Route::post('logout', 'bx8\PlatformController@forceLogOut');
    Route::get('trader', 'bx8\PlatformController@trader');
    Route::post('register', 'bx8\PlatformController@register');
    Route::post('update', 'bx8\PlatformController@update');
    Route::post('forgot', 'bx8\PlatformController@forgot');
    Route::post('reset-password', 'bx8\PlatformController@setPassword');
    Route::post('payment-form', 'bx8\PlatformController@getPaymentRedirect');
});
