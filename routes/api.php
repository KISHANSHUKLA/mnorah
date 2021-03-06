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
    Route::post('updateProfile', 'Api\AppuserAuthController@updateProfile');
    Route::get('user','Api\AppuserAuthController@getuser');
Route::get('emailVerification', 'Api\AppuserAuthController@emailVerification');
    Route::post('verifyEmail', 'Api\AppuserAuthController@verifyEmail');
    Route::resource('church', 'Api\AppChurchController');
    Route::post('search','Api\AppChurchController@getSearch');
    Route::post('invitecode','Api\AppChurchController@invitecode');
    Route::post('invitecodecheck','Api\AppChurchController@invitecodecheck');
    
    Route::post('churchDetail','Api\AppChurchController@churchDetail');

    Route::post('follow', 'Api\followersController@followUser')->name('follow');   
    Route::post('unfollow', 'Api\followersController@unFollowUser')->name('unfollow');  
    Route::get('followlist','Api\followersController@followlist')->name('followlist');

          
    Route::get('event','Api\EventController@index');
    Route::post('addevent','Api\EventController@addEvent');
    Route::post('deletevent','Api\EventController@eventDelete');
    Route::post('event/like','Api\EventController@eventLike');
    Route::post('event/share','Api\EventController@eventShare');
    Route::post('event/comment','Api\EventController@eventComment');
    Route::post('event/witness','Api\EventController@eventWitness');
    Route::post('event/eventLikeList','Api\EventController@eventlikeList');
    Route::post('event/eventCommentList','Api\EventController@eventCommentList');
    Route::post('event/eventWitnessList','Api\EventController@eventWitnessList');
    Route::post('event/eventShareList','Api\EventController@eventShareList');

    //Route::get('/group/create', 'Api\GroupController@create_form');
    Route::get('/group/list', 'Api\GroupController@getGroups');
    Route::post('/group/create', 'Api\GroupController@create');
    //Route::get('/group/edit/{id}', 'Api\GroupController@edit');
    Route::post('/group/update/{id}', 'Api\GroupController@update');
    Route::delete('/group/delete/{id}', 'Api\GroupController@delete');
    Route::get('/types', 'Api\GroupController@types');
    Route::get('/group/{id}', 'Api\GroupController@show_group');
    Route::post('/send_message/{id}', 'Api\MessageController@send_message');
    Route::get('/send_message/type/{id}', 'Api\MessageController@typemessage');


    //Route::get('/group/join', 'Api\GroupController@join_form');

    Route::post('/group/join', 'Api\GroupController@join');

    //Route::get('/group/{id}', 'Api\GroupController@show_group');
    Route::get('/group/members_list/{id}', 'Api\GroupController@members_list');

    Route::get('/remove_user/{id}/{user_id}', 'Api\GroupController@remove_user');
    //Route::get('/show_messages/{id}', 'Api\MessageController@show_messages');
});
