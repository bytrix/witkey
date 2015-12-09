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
Route::get('login', 'UserController@login');
Route::get('logout', 'UserController@logout');
Route::get('register', 'UserController@register');
Route::get('dashboard', ['before'=>'auth', 'uses'=>'UserController@dashboard']);



Route::post('login', 'UserController@postLogin');
Route::post('register', 'UserController@postRegister');