<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', 'TaskController@index');
Route::get('about', function() { return View::make('layout.about'); });
Route::get('login', 'UserController@login');
Route::get('logout', 'UserController@logout');
Route::get('register', 'UserController@register');
Route::get('task/list', 'TaskController@listTask');
Route::get('task/{id}', 'TaskController@detail')->where('id', '[0-9]+');

Route::group(['before'=>'auth'], function() {
	Route::get('dashboard', 'UserController@dashboard');
	Route::get('dashboard/profile', 'UserController@dashboard');
	Route::get('dashboard/mytask', 'UserController@mytask');
	Route::get('dashboard/security', 'UserController@security');
	Route::get('task/new', 'TaskController@create');
	Route::get('task/new/set-reward', 'TaskController@setReward');
	Route::get('task/new/bill', 'TaskController@bill');
	Route::get('task/new/postTask', 'TaskController@postTask');
});

Route::post('login', 'UserController@postLogin');
Route::post('register', 'UserController@postRegister');