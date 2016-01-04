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
Route::get('/'				, 'HomeController@index');
Route::get('about'			, 'HomeController@about');
Route::get('login'			, 'UserController@login');
Route::get('logout'			, 'UserController@logout');
Route::get('register'		, 'UserController@register');
Route::get('user/{user_id}'	, 'UserController@profile')->where('user_id', '[0-9]+');
Route::get('task/{task_id}'	, 'TaskController@detail')->where('task_id', '[0-9]+');
Route::get('task/list'		, 'TaskController@listTask');

// POST
Route::post('login'		, 'UserController@postLogin');
Route::post('register'	, 'UserController@postRegister');

Route::group(['before'=>'auth'], function() {
	// GET
	Route::get('dashboard'								, 'DashboardController@overview');
	Route::get('dashboard/myProfile'					, 'DashboardController@myProfile');
	Route::get('dashboard/taskOrder'					, 'DashboardController@taskOrder');
	Route::get('dashboard/postcard'						, 'DashboardController@postcard');
	Route::get('dashboard/favoriteTask'					, 'DashboardController@favoriteTask');
	Route::get('dashboard/security'						, 'DashboardController@security');
	Route::get('dashboard/authentication'				, 'DashboardController@authentication');
	Route::get('task/create'							, 'TaskController@step_1');
	Route::get('task/create/step-2'						, 'TaskController@step_2');
	Route::get('task/create/step-3'						, 'TaskController@step_3');
	Route::get('task/create/postCreate'					, 'TaskController@postCreate');
	Route::get('task/{task_id}/edit'					, 'TaskController@edit')->where('task_id', '[0-9]+');
	Route::get('task/{task_id}/hosting/1{bid_id}'		, 'TaskController@commitHosting')->where('task_id', '[0-9]+')->where('bid_id', '[0-9]+');
	Route::get('task/{task_id}/hosting/2{bid_id}'		, 'TaskController@quoteHosting')->where('task_id', '[0-9]+')->where('bid_id', '[0-9]+');
	Route::get('task/{task_id}/hosting/{bid_id}/win_bid', 'TaskController@winBid')->where('task_id', '[0-9]+')->where('bid_id', '[0-9]+');
	Route::get('/pay/{commit_id}'						, 'TaskController@pay')->where('commit_id', '[0-9]+');
	Route::post('/pay'									, 'TaskController@postPay');


	// POST
	Route::post('dashboard/security'		, 'DashboardController@postSecurity');
	Route::post('dashboard/myProfile'		, 'DashboardController@postMyProfile');
	Route::post('dashboard/authentication'	, 'DashboardController@postAuthentication');
	Route::post('task/create/step-2'		, 'TaskController@step_2');
	Route::post('task/create/step-3'		, 'TaskController@step_3');
	Route::post('task/{task_id}/edit'		, 'TaskController@postEdit')->where('task_id', '[0-9]+');
	Route::post('task/{task_id}/postQuit'	, 'TaskController@postQuit')->where('task_id', '[0-9]+');

	// POST API FOR JAVASCRIPT
	Route::post('api/hasFavoriteTask/{task_id}'		, 'TaskApiController@hasFavoriteTask')->where('task_id', '[0-9]+');
	Route::post('api/markFavoriteTask/{task_id}'	, 'TaskApiController@markFavoriteTask')->where('task_id', '[0-9]+');
	Route::post('api/removeFavoriteTask/{task_id}'	, 'TaskApiController@removeFavoriteTask')->where('task_id', '[0-9]+');

	// realname Authentication
	Route::group(['before'=>'realname'], function() {
		Route::post('task/{task_id}/commit'	, 'TaskController@postCommit')->where('task_id', '[0-9]+');
		Route::post('task/{task_id}/quote'	, 'TaskController@postQuote')->where('task_id', '[0-9]+');
	});
});


Route::get('admin/auth'	, 'AdminController@auth');
Route::get('admin/auth/student-card/preview/{user_id}', 'AdminController@studentCardPreview')->where('user_id', '[0-9]+');

Route::get('admin/getUsers'					, 'AdminController@getUsers');
Route::get('admin/postAuthTobe/{user_id}'	, 'AdminController@postAuthTobe');
Route::get('admin/postAuthSuccess/{user_id}', 'AdminController@postAuthSuccess');
Route::get('admin/postAuthFail/{user_id}'	, 'AdminController@postAuthFail');

// FOR ANGULAR API
Route::get('api/taskState/{task_id}'			, 'TaskApiController@taskState')->where('task_id', '[0-9]+');

// Academy Configuration
Route::get('config/academy/', function() {
	return Academy::allAcademies();
});
Route::get('config/academy/{academy_code}', function($academy_code) {
	return Academy::getAcademy($academy_code);
});

Route::get('config/major/', function() {
	return Academy::allMajors();
});
Route::get('config/major/{major_code}', function($major_code) {
	return Academy::getMajor($major_code);
});


Route::get('test', function() {
	return View::make('test');
});