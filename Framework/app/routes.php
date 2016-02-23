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
Route::get('/'                                         , 'HomeController@index');
Route::get('about'                                     , 'HomeController@about');
Route::get('login'                                     , 'UserController@login');
Route::get('logout'                                    , 'UserController@logout');
Route::get('register'                                  , 'UserController@register');
Route::get('user/{user_id}'                            , 'UserController@profile')->where('user_id', '[0-9]+');
Route::get('task/{task_id}'                            , 'TaskController@detail')->where('task_id', '[0-9]+');
Route::get('reportUser/{user_id}', array('before'=>'permision', 'uses'=>'UserController@report'));
Route::get('recruit', function() {
	return View::make('layout.recruit');
});

// Route::get('task/list'                              , 'TaskController@listTask');
Route::get('school/{academy_id}/'                       , 'TaskController@listTask')->where('academy_id', '[0-9]+');
Route::get('school/{academy_id}/category/{category_id}', 'TaskController@subCategory')->where('academy_id', '[0-9]+')->where('category_id', '[0-9]+');
Route::get('school/{academy_id}/search/{keyword}', 'TaskController@search');
Route::get('school'                                    , function() { return Redirect::to('/'); });

// POST
Route::post('login'		, 'UserController@postLogin');
Route::post('register'	, 'UserController@postRegister');
Route::post('reportUser/{user_id}', 'UserController@postReport');

Route::group(['before'=>'auth'], function() {
	// GET
	Route::get('dashboard'                              , 'DashboardController@overview');
	Route::get('dashboard/myProfile'                    , 'DashboardController@myProfile');
	Route::get('dashboard/changeAvatar'                    , 'DashboardController@changeAvatar');
	Route::get('dashboard/taskOrder'                    , 'DashboardController@taskOrder');
	Route::get('dashboard/rate/{task_id}'               , 'DashboardController@rate')->where('task_id', '[0-9]+');
	Route::get('dashboard/postcard'                     , 'DashboardController@postcard');
	Route::get('dashboard/favoriteTask'                 , 'DashboardController@favoriteTask');
	Route::get('dashboard/myFriends'                 , 'DashboardController@myFriends');
	Route::get('dashboard/security'                     , 'DashboardController@security');
	Route::get('dashboard/authentication'               , 'DashboardController@authentication');
	Route::get('task/create'                            , 'TaskController@step_1');
	Route::get('task/create/step-2'                     , 'TaskController@step_2');
	Route::get('task/create/step-3'                     , 'TaskController@step_3');
	Route::get('task/create/postCreate'                 , 'TaskController@postCreate');
	Route::get('task/{task_id}/edit'                    , 'TaskController@edit')->where('task_id', '[0-9]+');
	Route::get('task/{task_id}/hosting/1{bid_id}'       , 'TaskController@commitHosting')->where('task_id', '[0-9]+')->where('bid_id', '[0-9]+');
	Route::get('task/{task_id}/hosting/2{bid_id}'       , 'TaskController@quoteHosting')->where('task_id', '[0-9]+')->where('bid_id', '[0-9]+');
	Route::get('task/{task_id}/hosting/{bid_id}/win_bid', 'TaskController@winBid')->where('task_id', '[0-9]+')->where('bid_id', '[0-9]+');
	Route::get('pay/{commit_uuid}'                     , 'TaskController@pay')->where('commit_uuid', '[0-9a-z]+');
	Route::get('pay/{commit_uuid}/success'             , 'TaskController@successPay')->where('commit_uuid', '[0-9a-z]+');

	Route::get('message', 'UserController@message');
	Route::get('message/{message_id}', 'UserController@detailMessage')->where('message_id', '[0-9]+');
	Route::get('message/all', 'UserController@allMessages');
	Route::get('message/send', 'UserController@sendMessage');
	Route::get('message/read-all', 'UserController@readAllMessages');
	Route::get('message/sent', 'UserController@sentMessage');
	

	// POST
	Route::post('dashboard/set-username', 'DashboardController@setUsername');
	Route::post('dashboard/security'      , 'DashboardController@postSecurity');
	Route::post('dashboard/myProfile'     , 'DashboardController@postMyProfile');
	Route::post('dashboard/changeAvatar', 'DashboardController@postAvatar');
	Route::post('dashboard/rate/{task_id}', 'DashboardController@postRate')->where('task_id', '[0-9]+');
	Route::post('dashboard/authentication', 'DashboardController@postAuthentication');
	Route::post('task/create/step-2'      , 'TaskController@step_2');
	Route::post('task/create/step-3'      , 'TaskController@step_3');
	Route::post('task/{task_id}/edit'     , 'TaskController@postEdit')->where('task_id', '[0-9]+');
	Route::post('task/{task_id}/postQuit' , 'TaskController@postQuit')->where('task_id', '[0-9]+');
	Route::post('task/{task_id}/delay'    , 'TaskController@postDelay')->where('task_id', '[0-9]+');
	Route::post('task/{task_id}/changeCategory', 'TaskController@changeCategory')->where('task_id', '[0-9]+');
	Route::post('task/{task_id}/delete', 'TaskController@deleteTask')->where('task_id', '[0-9]+');
	Route::post('message/send', 'UserController@postMessage');

	// realname Authentication
	Route::group(['before'=>'realname'], function() {
		Route::post('task/{task_id}/commit', 'TaskController@postCommit')->where('task_id', '[0-9]+');
		Route::post('task/{task_id}/quote' , 'TaskController@postQuote')->where('task_id', '[0-9]+');
	});
});


Route::get('myAdmin/auth'                               , 'AdminController@auth');
Route::get('myAdmin/auth/student-card/preview/{user_id}', 'AdminController@studentCardPreview')->where('user_id', '[0-9]+');

Route::get('myAdmin/academy'              , 'AdminController@academy');
Route::get('myAdmin/academy/{academy_id}' , 'AdminController@academyDetail')->where('academy_id', '[0-9]+');
Route::post('myAdmin/academy'             , 'AdminController@postAcademy');
Route::post('myAdmin/academy/{academy_id}', 'AdminController@postMajor')->where('academy_id', '[0-9]+');

Route::get('myAdmin/permission', 'AdminController@permission');
Route::get('myAdmin/chmod/{user_id}/{permission}', 'AdminController@chmod')->where('user_id', '[0-9]+')->where('permission', '[0-3]+');





Route::get('api/follow/{follower_id}', 'ApiController@follow')->where('follower_id', '[0-9]+');
Route::get('api/unfollow/{follower_id}', 'ApiController@unfollow')->where('follower_id', '[0-9]+');
Route::get('api/hasFollower/{follower_id}', 'ApiController@hasFollower')->where('follower_id', '[0-9]+');








Route::get('api/getUsers'                   , 'ApiController@getUsers');
Route::get('api/authUser'                   , 'ApiController@authUser');
Route::get('api/postAuthTobe/{user_id}'     , 'ApiController@postAuthTobe');
Route::get('api/postAuthSuccess/{user_id}'  , 'ApiController@postAuthSuccess');
Route::get('api/postAuthFail/{user_id}'     , 'ApiController@postAuthFail');

// Academy Configuration
// Route::get('config/academy/'                  , 'ApiController@allAcademies');
// Route::get('config/major/'                    , 'ApiController@allMajors');
// Route::get('config/academy/{academy_code}'    , 'ApiController@getAcademy');
// Route::get('config/major/{major_code}'        , 'ApiController@getMajor');

// API
Route::get('api/academy/getAcademies'         , 'ApiController@allAcademies');
Route::get('api/academy/getMajors'            , 'ApiController@allMajors');

// POST API FOR JAVASCRIPT
Route::post('api/hasFavoriteTask/{task_id}'   , 'ApiController@hasFavoriteTask')->where('task_id', '[0-9]+');
Route::post('api/markFavoriteTask/{task_id}'  , 'ApiController@markFavoriteTask')->where('task_id', '[0-9]+');
Route::post('api/removeFavoriteTask/{task_id}', 'ApiController@removeFavoriteTask')->where('task_id', '[0-9]+');

// FOR ANGULAR API
Route::get('api/taskState/{task_id}'          , 'ApiController@taskState')->where('task_id', '[0-9]+');

Route::controller('password', 'RemindersController');

// App::error(function($exception, $code) {
// 	return Response::view('error.404', array(), 404);
// });

// Route::get('/test', function() {
// 	var_dump(Auth::user()->getPermission());
// });

// Route::post('/test', function() {
// 	return var_dump(Input::all());
// });

Route::get('request', function() {
	require_once '../vendor/autoload.php'; //加载Composer自动生成的autoload
	$service = new Eva\EvaOAuth\Service('Weibo', [
		'key' => '101290815',
		'secret' => 'd7d4c475f2229df62bcc9ee64cd8eb9c',
		'callback' => 'http://localhost/access'
	]);
	echo '<pre>';
	var_dump($service);
	echo '</pre>';
	$service->requestAuthorize();
});

Route::get('access', function() {
	dd('dd');
	require_once '../vendor/autoload.php'; //加载Composer自动生成的autoload
	$token = $service->getAccessToken();
	$httpClient = new Eva\EvaOAuth\AuthorizedHttpClient($token);
	$response = $httpClient->get('https://graph.qq.com/user/get_user_info?oauth_consumer_key=100330589&access_token=C8DC5F803954B582B6AD215083B6EDE7&openid=133C2F3092CE16620BF629F756660C45&format=json');
});
