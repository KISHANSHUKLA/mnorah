<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

    

});

// Route::group(['prefix' => 'auth'], function(){
//     Route::post('register', 'Api\AppuserAuthController@register');
//     Route::post('/login','Api\AppuserAuthController@login');
// });

// // Route::post('/register','Api\AppuserAuthController@register');
// // Route::post('/login','Api\AppuserAuthController@login');
// // Route::post('/logout','Api\AppuserAuthController@logout');
// Route::group(['middleware' => 'auth:api'], function () {
//     Route::get('user', 'Api\AppuserAuthController@user');
//     Route::get('logout', 'Api\AppuserAuthController@logout');
// });

Route::post('login', 'API\AppuserAuthController@login');
Route::post('register', 'API\AppuserAuthController@register');
Route::post('password/email', 'API\AppuserAuthController@forgot');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('logout', 'Api\AppuserAuthController@logout');
    Route::get('emailVerification', 'API\AppuserAuthController@emailVerification');
    Route::post('verifyEmail', 'Api\AppuserAuthController@verifyEmail');
    
    
});
