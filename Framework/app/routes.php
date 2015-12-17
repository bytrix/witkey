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
//GET
Route::group(['before'=>'realname'], function() {
});
Route::get('/', 'TaskController@index');
Route::get('about', function() { return View::make('layout.about'); });
Route::get('login', 'UserController@login');
Route::get('logout', 'UserController@logout');
Route::get('register', 'UserController@register');
Route::get('user/{id}', 'UserController@profile')->where('id', '[0-9]+');
Route::get('task/list', 'TaskController@listTask');
Route::get('task/{id}', 'TaskController@detail')->where('id', '[0-9]+');

// POST
Route::post('login', 'UserController@postLogin');
Route::post('register', 'UserController@postRegister');

Route::group(['before'=>'auth'], function() {
	// GET
	Route::get('dashboard', 'UserController@overview');
	Route::get('dashboard/profile', 'UserController@myProfile');
	Route::get('dashboard/taskOrder', 'UserController@taskOrder');
	Route::get('dashboard/postcard', 'UserController@postcard');
	Route::get('dashboard/taskFollow', 'UserController@taskFollow');
	Route::get('dashboard/authentication', 'UserController@authentication');
	Route::get('dashboard/security', 'UserController@security');
	// realname Authentication
	Route::group(['before'=>'realname'], function() {
		Route::get('task/new', 'TaskController@create');
		Route::get('task/new/set-reward', 'TaskController@setReward');
		Route::get('task/new/bill', 'TaskController@bill');
		Route::get('task/new/postTask', 'TaskController@postTask');
		Route::get('task/{id}/edit', 'TaskController@edit')->where('id', '[0-9]+');
	});

	// POST
	Route::post('dashboard/profile', 'UserController@postMyProfile');
	Route::post('dashboard/security', 'UserController@postSecurity');
	Route::post('dashboard/authentication', 'UserController@postAuthentication');
	// realname Authentication
	Route::group(['before'=>'realname'], function() {
		Route::post('task/{id}/enrollment', 'TaskController@enrollment')->where('id', '[0-9]+');
		Route::post('task/{id}/quit', 'TaskController@quit')->where('id', '[0-9]+');
		Route::post('task/new/set-reward', 'TaskController@setReward');
		Route::post('task/new/bill', 'TaskController@bill');
		Route::post('task/{id}/edit', 'TaskController@postEdit')->where('id', '[0-9]+');
	});
});
