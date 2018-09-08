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


Route::resource('data/projects', 'ProjectsController');
Route::resource('data/projects.teams', 'ProjectsTeamsController');
Route::resource('data/projects.tasks', 'TasksController');


Route::get('{all}', 'HomeController@router')->where(['all' => '.*']);
