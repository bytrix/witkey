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
use Omnipay\Omnipay;
//GET
Route::get('/'                                         , 'HomeController@index');
Route::get('help'                                     , 'HomeController@help');
Route::get('login'                                     , 'UserController@login');
Route::get('logout'                                    , 'UserController@logout');
Route::get('register'                                  , 'UserController@register');
Route::get('user/{user_id}'                            , 'UserController@profile')->where('user_id', '[0-9]+');
Route::get('task/{task_id}'                            , 'TaskController@detail')->where('task_id', '[0-9]+');
Route::get('task/{task_id}/commit/{bidder_id}', 'TaskController@historyCommit')->where(array('task_id'=>'[0-9]+', 'bidder_id'=>'[0-9]+'));
Route::get('reportUser/{user_id}', array('before'=>'permision', 'uses'=>'UserController@report'));
Route::get('recruit', function() {
	return View::make('layout.recruit');
});
Route::get('task/manual'                            , 'TaskController@manual');

// Route::get('task/list'                              , 'TaskController@listTask');
Route::get('school/{academy_id}/'                       , 'TaskController@listTask')->where('academy_id', '[0-9]+');

// Route::get('school/{academy_id}', array('https', 'TaskController@listTask'))->where('academy_id', '[0-9]+');

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
	Route::post('task/create/uploadImage', 'TaskController@uploadImage');
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




	Route::group(['before'=>'admin'], function() {

		Route::get('myadmin/login', 'AdminController@login');
		Route::post('myadmin/login', 'AdminController@postLogin');

		Route::group(['before'=>'adminLogin'], function() {

			Route::get('myadmin', 'AdminController@home');
			Route::get('myadmin/quit', 'AdminController@quit');
			Route::get('myadmin/auth'                               , 'AdminController@auth');
			Route::get('myadmin/auth/student-card/preview/{user_id}', 'AdminController@studentCardPreview')->where('user_id', '[0-9]+');

			Route::get('myadmin/academy'              , 'AdminController@academy');
			Route::get('myadmin/academy/{academy_id}' , 'AdminController@academyDetail')->where('academy_id', '[0-9]+');
			Route::post('myadmin/academy'             , 'AdminController@postAcademy');
			Route::post('myadmin/academy/{academy_id}', 'AdminController@postMajor')->where('academy_id', '[0-9]+');

			Route::get('myadmin/permission', 'AdminController@permission');
			Route::get('myadmin/chmod/{user_id}/{permission}', 'AdminController@chmod')->where('user_id', '[0-9]+')->where('permission', '[0-3]+');

		});


	});




});





Route::get('api/follow/{follower_id}', 'ApiController@follow')->where('follower_id', '[0-9]+');
Route::get('api/unfollow/{follower_id}', 'ApiController@unfollow')->where('follower_id', '[0-9]+');
Route::get('api/hasFollower/{follower_id}', 'ApiController@hasFollower')->where('follower_id', '[0-9]+');








Route::get('api/getUsers'                   , 'ApiController@getUsers');
Route::get('api/authUser'                   , 'ApiController@authUser');
Route::get('api/postAuthTobe/{user_id}'     , 'ApiController@postAuthTobe');
Route::get('api/postAuthSuccess/{user_id}'  , 'ApiController@postAuthSuccess');
Route::get('api/postAuthFail/{user_id}/{reason}'     , 'ApiController@postAuthFail');

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

// Route::get('request', function() {
// 	require_once './vendor/autoload.php'; //加载Composer自动生成的autoload
// 	$service = new Eva\EvaOAuth\Service('Tencent', [
// 		'key' => '1105196242',
// 		'secret' => 'A9afBmqZudoVoXkY',
// 		'callback' => 'http://localhost/access'
// 	]);
// 	// echo '<pre>';
// 	// var_dump($service);
// 	// echo '</pre>';
// 	$service->requestAuthorize();
// });

// Route::get('access', function() {
// 	// dd('dd');
// 	require_once './vendor/autoload.php'; //加载Composer自动生成的autoload
// 	$token = $service->getAccessToken();
// 	$httpClient = new Eva\EvaOAuth\AuthorizedHttpClient($token);
// 	$response = $httpClient->get('https://graph.qq.com/user/get_user_info?oauth_consumer_key=100330589&access_token=C8DC5F803954B582B6AD215083B6EDE7&openid=133C2F3092CE16620BF629F756660C45&format=json');
// });


Route::get('gateway', function() {

	$gateway = Omnipay::create('Alipay_Express');
	$gateway->setPartner('2088002026520434');
	$gateway->setKey('4q1b99qcqp65o1b1v9yiapx0fwhejz58');
	$gateway->setSellerEmail('wengzhijie@126.com');
	$gateway->setReturnUrl('http://www.campuswitkey.com/return');
	$gateway->setNotifyUrl('http://www.campuswitkey.com/notify');

	//For 'Alipay_MobileExpress', 'Alipay_WapExpress'
	//$gateway->setPrivateKey('/such-as/private_key.pem');

	$options = [
	    'out_trade_no' => date('YmdHis') . mt_rand(1000,9999), //your site trade no, unique
	    'subject'      => 'test', //order title
	    'total_fee'    => '0.01', //order total fee
	];

	$response = $gateway->purchase($options)->send();

	$demo = $response->getRedirectUrl();
	$demo1 = $response->getRedirectData();
	echo '<pre>';
	// var_dump($response->getOrderString());
	echo '</pre>';

	//For 'Alipay_MobileExpress'
	//Use the order string with iOS or Android SDK
	// $response->getOrderString();



});

Route::get('sms/{code}/{phone}', function($code, $userPhone) {

	// Session::put($userPhone, $code);
	// // Session::forget($userPhone);
	// var_dump(Session::get($userPhone));

	if (!Session::has($userPhone)) {
		Session::put($userPhone, $code);
	}

	function str2hex($str){
		// $str .= '00';
		$hex = '';
		for($i=0,$length=mb_strlen($str); $i<$length; $i++){
			$hex .= dechex(ord($str{$i}));
		}
		return $hex;
	}

	$code_hex = strtoupper(str2hex(iconv('UTF-8', 'GBK', Session::get($userPhone))));

	$username = 'N13358212686';
	$password = '511913';
	$sm = 'A1BED0A3D4B0CDFEBFCDA1BFC4FAB5C4D1E9D6A4C2EBCAC7A3BA'.$code_hex.'A3ACB4CBD1E9D6A4C2EBBDF6CACAD3C3D3DAD0A3D4B0CDFEBFCDCDF8D5BEB5C4D7A2B2E1BACDB5C7C2BCA3ACCEAAB1A3BBA4C4FAB5C4D5CBBAC5B0B2C8ABC7EBCEF0D7AAB7A2A1A3';
	
	$ch = curl_init();
	// $timeout = 5;
	curl_setopt ($ch, CURLOPT_URL, 'http://222.73.117.138:7891/mt?un='.$username.'&pw='.$password.'&da='.$userPhone.'&sm='.$sm.'&dc=15&rd=1');
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	// curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	curl_close($ch);

});


Route::get('demo-push', function() {
	// Session::push('hello', 'hehe');
	Session::pull('hello');
});

Route::get('demo-get', function() {
	// var_dump(Session::get('images', '-'));
	foreach (Session::get('images') as $image) {
		var_dump($image);
		echo '<br />';
	}
});


// Route::get('ip', function() {
// 	// echo $_SERVER['SERVER_ADDR'];
// 	echo '<pre>';
// 	print_r($_SERVER);
// 	echo '</pre>';
// 	// echo Config::get('server.ip');
// });


// Route::get('set', function() {
// 	Cookie::queue('value', 'testValue', 10);
// 	// var_dump(Session::get('value'));
// 	// var_dump(Cookie::get('value'));
// });

// Route::get('get', function() {
// 	var_dump(Cookie::get('value'));
// });


Route::post('upload/post', function() {
	$user = new User;
	$user->username = Input::all();
	$user->save();
});

Route::get('demo', function() {
	return route('home');
	// return View::make('demo');
	// return date('YmdHis');
	// var_dump(public_path() . '/upload');
});

Route::post('demo', function() {
	echo '<pre>';
	var_dump(Input::file('file'));
	echo '</pre>';
	// var_dump(Input::hasFile('file'));
});


Route::get('upload-demo', 'TaskController@uploadImage');