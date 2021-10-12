<?php

Route::group(['prefix' => '/v1', 'middleware' => ['auth:api'], 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::post('change-password', 'ChangePasswordController@changePassword')->name('auth.change_password');
    Route::apiResource('roles', 'RolesController');
    Route::apiResource('users', 'UsersController');
    Route::apiResource('titles', 'TitleController');
    Route::apiResource('permission-lists', 'PermissionListController');
    Route::apiResource('companies', 'CompaniesController');

    
    Route::get('projects/assigned-user-list', 'ProjectController@getAssignedUserList');
    Route::get('projects/all-assign', 'ProjectController@getAssignAll');
    Route::apiResource('projects', 'ProjectController');

    Route::apiResource('project-assign', 'ProjectAssignController');

    Route::post('file-upload', 'UploadController@upload');
    Route::get('get-auth', 'UsersController@getAuth');

    Route::get('timecards/get-user-data/{projectId}/{userId}/{startDate}/{endDate}', 'TimecardController@getUserData');
    Route::get('timecards/get-all/{projectId}/{startDate}/{endDate}', 'TimecardController@getAll');
    Route::get('timecards/get-week-data/{projectId}/{userId}/{startDate}/{endDate}', 'TimecardController@getWeekData');
    Route::post('timecards/add-entry', 'TimeCardController@addEntry');
    Route::get('timecards/delete-entry/{id}', 'TimeCardController@deleteEntry');
    Route::post('timecards/add-checkin', 'TimeCardController@addCheckin');
    Route::post('timecards/get-checkins-data', 'TimeCardController@getCheckinsData');
    Route::get('timecards/delete-checkin/{id}', 'TimeCardController@deleteCheckin');
    
    Route::apiResource('timecards', 'TimecardController');
});
