<?php
Route::redirect('/', 'admin/home');

Auth::routes(['register' => false]);

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::delete('permissions_mass_destroy', 'Admin\PermissionsController@massDestroy')->name('permissions.mass_destroy');
    Route::resource('roles', 'Admin\RolesController');
    Route::resource('feeds', 'feedController');
    Route::delete('roles_mass_destroy', 'Admin\RolesController@massDestroy')->name('roles.mass_destroy');
    Route::resource('users', 'Admin\UsersController');
    Route::get('appusers', 'Admin\UsersController@appUser')->name('appusers');
    Route::delete('users_mass_destroy', 'Admin\UsersController@massDestroy')->name('users.mass_destroy');
    Route::resource('churches', 'ChurchController');
    Route::resource('invitecode', 'InvitecodeController');    
    Route::get('/codeimport', 'InvitecodeController@importcode')->name('codeimport');   
    Route::get('/requestlist', 'InvitecodeController@requestlist')->name('requestlist');   
    Route::get('/requestlist/{id}', 'InvitecodeController@requestlistEdit')->name('requestlist.edit');  
    Route::put('/requestlistupdate/{id}', 'InvitecodeController@requestlistupdate')->name('requestlist.update');  
    Route::post('import', 'InvitecodeController@import')->name('invitecode.import');   
    Route::get('/codestatus/{id}', 'InvitecodeController@codestatus')->name('codestatus');  
    Route::get('/leadership/{id}', 'Admin\UsersController@leadership')->name('leadership');  
     Route::get('/community/{id}', 'feedController@community')->name('community');
     Route::get('/medically/{id}', 'feedController@medically')->name('medically');

    Route::get('/feed/{id}', 'Admin\UsersController@feedapprove')->name('approvefeed'); 
    Route::get('/rejectfeed/{id}', 'Admin\UsersController@rejectfeed')->name('rejectfeed');  
});
