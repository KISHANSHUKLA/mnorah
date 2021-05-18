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

//Route::post('login', 'API\AppuserAuthController@login');
Route::post('register', 'Api\AppuserAuthController@register');
Route::post('social', 'Api\AppuserAuthController@social');
Route::post('password/email', 'Api\AppuserAuthController@forgot');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('logout', 'Api\AppuserAuthController@logout');
    Route::get('user','Api\AppuserAuthController@getuser');
Route::get('emailVerification', 'Api\AppuserAuthController@emailVerification');
    Route::post('verifyEmail', 'Api\AppuserAuthController@verifyEmail');
    Route::resource('church', 'Api\AppChurchController');
    Route::post('search','Api\AppChurchController@getSearch');
    
    Route::post('churchDetail','Api\AppChurchController@churchDetail');

    Route::post('follow', 'Api\followersController@followUser')->name('follow');   
    Route::post('unfollow', 'Api\followersController@unFollowUser')->name('unfollow');  
    Route::get('followlist','Api\followersController@followlist')->name('followlist');

          
    Route::get('event','Api\EventController@index');
    Route::post('addevent','Api\EventController@addEvent');
    Route::post('deletevent','Api\EventController@eventDelete');

});
