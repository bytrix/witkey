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
Route::get('/', 'TaskController@index');
Route::get('about', function() { return View::make('layout.about'); });
Route::get('login', 'UserController@login');
Route::get('logout', 'UserController@logout');
Route::get('register', 'UserController@register');
Route::get('user/{id}', 'UserController@mxp')->where('id', '[0-9]+');
Route::get('task/list', 'TaskController@listTask');
Route::get('task/{id}', 'TaskController@detail')->where('id', '[0-9]+');

// POST
Route::post('login', 'UserController@postLogin');
Route::post('register', 'UserController@postRegister');
Route::post('dashboard/profile', 'UserController@postProfile');

Route::group(['before'=>'auth'], function() {
	// GET
	Route::get('dashboard', 'UserController@overview');
	Route::get('dashboard/profile', 'UserController@profile');
	Route::get('dashboard/myDemands', 'UserController@myDemands');
	Route::get('dashboard/authentication', 'UserController@authentication');
	Route::get('dashboard/security', 'UserController@security');
	Route::get('demand/new', 'TaskController@create');
	Route::get('demand/new/set-reward', 'TaskController@setReward');
	Route::get('demand/new/bill', 'TaskController@bill');
	Route::get('demand/new/postDemand', 'TaskController@postDemand');
	// POST
	Route::post('dashboard/security', 'UserController@postSecurity');
	Route::post('dashboard/authentication', 'UserController@postAuthentication');
	Route::post('task/{id}/enrollment', 'TaskController@enrollment')->where('id', '[0-9]+');
	Route::post('task/{id}/quit', 'TaskController@quit')->where('id', '[0-9]+');
	Route::post('demand/new/set-reward', 'TaskController@setReward');
	Route::post('demand/new/bill', 'TaskController@bill');
});
