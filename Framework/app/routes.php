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
Route::post('favorite/{tid}', 'TaskController@favorite')->where('tid', '[0-9]+');

Route::group(['before'=>'auth'], function() {
	// GET
	Route::get('dashboard', 'UserController@overview');
	Route::get('dashboard/myProfile', 'UserController@myProfile');
	Route::get('dashboard/taskOrder', 'UserController@taskOrder');
	Route::get('dashboard/postcard', 'UserController@postcard');
	Route::get('dashboard/favoriteTask', 'UserController@favoriteTask');
	Route::get('dashboard/authentication', 'UserController@authentication');
	Route::get('dashboard/security', 'UserController@security');
	Route::get('task/new', 'TaskController@create');
	Route::get('task/new/set-reward', 'TaskController@setReward');
	Route::get('task/new/bill', 'TaskController@bill');
	Route::get('task/new/postTask', 'TaskController@postTask');
	// realname Authentication
	Route::group(['before'=>'realname'], function() {
		Route::get('task/{id}/edit', 'TaskController@edit')->where('id', '[0-9]+');
	});

	// POST
	Route::post('dashboard/profile', 'UserController@postMyProfile');
	Route::post('dashboard/security', 'UserController@postSecurity');
	Route::post('dashboard/authentication', 'UserController@postAuthentication');
	Route::post('task/{id}/quit', 'TaskController@quit')->where('id', '[0-9]+');
	Route::post('task/new/set-reward', 'TaskController@setReward');
	Route::post('task/new/bill', 'TaskController@bill');
	Route::post('task/{id}/edit', 'TaskController@postEdit')->where('id', '[0-9]+');
	// realname Authentication
	Route::group(['before'=>'realname'], function() {
		Route::post('task/{id}/enrollment', 'TaskController@enrollment')->where('id', '[0-9]+');
	});
});



// POST API FOR JAVASCRIPT
Route::group(['before'=>'auth'], function() {
	Route::post('hasFavoriteTask/{tid}', 'ApiController@hasFavoriteTask')->where('tid', '[0-9]+');
	Route::post('markFavoriteTask/{tid}', 'ApiController@markFavoriteTask')->where('tid', '[0-9]+');
	Route::post('removeFavoriteTask/{tid}', 'ApiController@removeFavoriteTask')->where('tid', '[0-9]+');
});
