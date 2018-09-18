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

Route::get('/', function () {
    return view('index');
})
->middleware('guest');

Auth::routes();


Route::get('/data/settings', 'SettingsController@edit');
Route::post('/data/settings', 'SettingsController@update');
Route::post('/data/settings/upload', 'SettingsController@upload');

Route::get('/data/profile/{user?}', 'ProfileController@index');
Route::get('/data/profile/{user}/avatar', 'ProfileController@avatar');

Route::get('/data/notifications', 'NotificationController@index');
Route::get('/data/notifications/markAllAsRead', 'NotificationController@markAllAsRead');
Route::put('/data/notifications/{notification}/markAsRead', 'NotificationController@markAsRead');

Route::get('data/projects', 'ProjectsController@index');
Route::post('data/projects', 'ProjectsController@store');
Route::get('data/projects/{project}', 'ProjectsController@show');

Route::post('data/projects/{project}/invite', 'ProjectsController@invite');
Route::post('data/projects/{project}/respondToInvitation', 'ProjectsController@respondToInvitation');
Route::post('data/projects/{project}/kick', 'ProjectsController@kick');


Route::get('data/projects/{project}/tasks', 'TasksController@index');
Route::post('data/projects/{project}/tasks', 'TasksController@store');
Route::get('data/projects/{project}/tasks/{task}', 'TasksController@show');

Route::post('data/projects/{project}/tasks/{task}/assign', 'TasksController@assign');
Route::post('data/projects/{project}/tasks/{task}/kick', 'TasksController@kick');
Route::post('data/projects/{project}/tasks/{task}/comment', 'TasksController@comment');

Route::get('{all}', 'HomeController@router')->where(['all' => '.*']);
