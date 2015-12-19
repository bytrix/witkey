<?php

class UserController extends BaseController {

		public static $schoolList = [
			'福州大学至诚学院',
		];
		public static $majorCategoryList = [
			'电气工程系',
			'信息工程系',
			'环境资源工程系',
			'生物工程系',
			'机械工程系',
			'材料工程系',
			'计算机工程系',
			'化学工程系',
			'土木工程系',
			'建筑系',
			'财经系',
			'管理系',
			'社会事务管理系',
			'外国语系',
			'音乐系',
			'创意与设计系'
		];
		public static $majorList = [
			'电气工程及其自动化',
			'自动化',
			'电子信息工程',
			'通信工程',
			'电子科学与技术',
			'微电子科学与工程',
			'计算机科学与技术',
			'软件工程',
			'网络工程',
			'机械设计制造及其自动化',
			'过程装备与控制工程',
			'工业设计',
			'材料成型及控制工程',
			'材料科学与工程',
			'环境工程',
			'安全工程',
			'生物工程',
			'食品科学与工程',
			'材料化学',
			'应用化学',
			'化学工程与工艺',
			'土木工程',
			'建筑学',
			'包装工程',
			'生物技术',
			'人文地理与城乡规划',
			'工程管理',
			'金融工程',
			'国际经济与贸易',
			'财务管理',
			'行政管理',
			'信息管理与信息系统',
			'物流管理',
			'英语',
			'日语',
			'商务英语',
			'汉语言文学',
			'音乐学',
			'产品设计',
		];

	public static function getGravatar( $email, $s = 200, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
		$url = 'https://secure.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&d=$d&r=$r";
		if ( $img ) {
			$url = '<img src="' . $url . '"';
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}
		return $url;
	}

	public static function getCity() {
		$city = file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=php');
		$city = explode('	', mb_convert_encoding($city, 'utf-8', 'gbk'));
		return $city[5];
	}


	// public static function downloadImage($url = '', $fileName = '') {
	// 	$ch = curl_init();
	// 	$fp = fopen('./public/avatar/' . $fileName, 'wb');

	// 	curl_setopt($ch, CURLOPT_URL, $url);
	// 	curl_setopt($ch, CURLOPT_FILE, $fp);
	// 	curl_setopt($ch, CURLOPT_HEADER, 0);
	// 	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	// 	curl_setopt($ch, CURLOPT_TIMEOUT, 60);

	// 	curl_exec($ch);
	// 	curl_close($ch);
	// 	fclose($fp);
	// }




	
	// GET
	public function login() {
		return View::make('user.login');
	}
	
	public function register() {
		return View::make('user.register');
	}

	public function logout() {
		Auth::logout();
		return Redirect::to('/');
	}

	public function profile($id) {
		$user = User::where('id', $id)->first();
		return View::make('user.profile')->with('user', $user);
	}


	// DASHBOARD FUNCTION GROUP
	public function overview() {
		$h = date('H');
		// dd(date('Y-m-d H:i:s'));
		$greeting = 'Welcome';
		if ($h>=0 && $h<5) {
			$greeting = 'Welcome';
		} else if($h>=5 && $h<11) {
			$greeting = 'Morning';
		} else if($h>=11 && $h<13) {
			$greeting = 'Good afternoon';
		} else if($h>=13 && $h<18) {
			$greeting = 'Good afternoon';
		} else if($h>=18 && $h<24) {
			$greeting = 'Good night';
		}



		// dd($this->getGravatar('wengzhijie@126.com'));


		return View::make('user.dashboard.overview')
			->with('greeting', $greeting)
			->with('gravatar_path', $this->getGravatar(Auth::user()->email));
	}

	public function myProfile() {
		return View::make('user.dashboard.myProfile');
	}


	public function taskOrder() {
		return View::make('user.dashboard.taskOrder');
	}

	// public function postcard() {
	// 	return View::make('user.dashboard.postcard');
	// }

	public function favoriteTask() {
		$favoriteTasks = Auth::user()->favoriteTasks();
		return View::make('user.dashboard.favoriteTask')->with('favoriteTasks', $favoriteTasks);
	}

	public function authentication() {
		// dd(var_dump(unserialize(Auth::user()->school)));
		return View::make('user.dashboard.authentication')
			->with('schoolList', self::$schoolList)
			->with('majorCategoryList', self::$majorCategoryList)
			->with('majorList', self::$majorList);
	}

	public function security() {
		return View::make('user.dashboard.security');
	}
	// END DASHBOARD FUNCTION GROUP


	// POST
	public function postLogin() {
		$userInput = [
			'email' => Input::get('email'),
			'password' => Input::get('password'),
		];
		$rules = [
			'email' => 'required|email',
			'password' => 'required|between:6,20'
		];

		$validator = Validator::make($userInput, $rules);

		if($validator->passes()) {
			if(Auth::attempt($userInput)) {
				return Redirect::to('dashboard');
			} else {
				return View::make('user.login')->with('message', 'email or password is incorrect!');
			}
		} else {
			return Redirect::to('login')->withErrors($validator);
		}
	}

	public function postRegister() {
		echo '<pre>';
		var_dump(Input::all());
		echo '</pre>';
		$userInput = [
			'email' => Input::get('email'),
			'password' => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation')
		];
		$rules = [
			'email' => 'required|email',
			'password' => 'required|between:6,20|confirmed',
		];
		$validator = Validator::make($userInput, $rules);

		if($validator->passes()) {
			$user = new User;
			$user->username = rand();
			$user->password = $userInput['password'];
			$user->email = $userInput['email'];
			$user->ip = Request::ip();
			$user->city = UserController::getCity();
			$user->save();
			// $fingerprint = md5($user->id . $user->created_at);
			// $this->downloadImage($this->getGravatar($user->email), $fingerprint);
			// $user->fingerprint = $fingerprint;
			// $user->save();
			Auth::login($user);
			return Redirect::to('dashboard');
		} else {
			return Redirect::to('register')->withErrors($validator);
		}

		return View::make('user.register');

	}

	public function postMyProfile() {
		// dd(Input::all());
		$userModify = [
			'username'=>Input::get('username'),
			'gender'=>Input::get('gender'),
			'tel'=>Input::get('tel'),
			'dorm'=>(Input::get('dorm_state')=='no' ? 'no' : Input::get('dorm')),
			'skill_tag'=>Input::get('skill_tag'),
		];
		User::where('id', Auth::user()->id)->update($userModify);
		return Redirect::to('dashboard/myProfile')->with('message', 'Data has been saved successfully!');
	}

	public function postSecurity() {
		$oldPasswordMatches = Hash::check(Input::get('old_password'), Auth::user()->password);
		if($oldPasswordMatches) {
			// Set a new password
			$userInput = [
				'password'=>Input::get('password'),
				'password_confirmation'=>Input::get('password_confirmation')
			];
			$rules = [
				'password'=>'required|between:6,20|confirmed'
			];
			$validator = Validator::make($userInput, $rules);
			if($validator->passes()) {
				User::where('id', Auth::user()->id)->update(['password'=>Hash::make($userInput['password'])]);
				return View::make('user.dashboard.security')->with('message', 'Password set successfully!');
			} else {
				return Redirect::to('dashboard/security')->withErrors($validator);
			}
		} else {
			return View::make('user.dashboard.security')->with('error', 'The password is incorrect!');
		}
		return View::make('user.dashboard.security');
	}

	public function postAuthentication() {
		// dd(var_dump(Input::all()));
		// $major = [
		// 	'majorCategory'=>self::$majorCategoryList[Input::get('major_category')],
		// 	'majorName'=>self::$majorList[Input::get('major')]
		// ];
		// TEXT INPUT
		$userInput = [
			'real_name'=>Input::get('real_name'),
			'school' => Input::get('school'),
			'idcard_image'=>Input::file('idcard_image'),
			'major_category'=>Input::get('major_category'),
			'major' => Input::get('major'),
			'enrollment_date'=>Input::get('enrollment_date'),
		];
		$rules = [
			'real_name'=>'required',
			'school'=>'required',
			'idcard_image'=>'mimes:jpeg,jpg,gif,bmp|max:1024',
			'major_category'=>'required',
			'major'=>'required',
			'enrollment_date'=>'required',
		];
		$validator = Validator::make($userInput, $rules);

		// FILE INPUT
		// $fileInput = [
		// 	'idcard_image'=>Input::file('idcard_image')
		// ];
		// $fileRules = [
		// 	'idcard_image'=>'required|mimes:jpeg,jpg,gif,bmp|max:1024'
		// ];
		// $fileValidator = Validator::make($fileInput, $fileRules);

		if ($validator->passes()) {
			if (!Input::hasFile('idcard_image') && !strlen(Auth::user()->fingerprint)) {	// when the file exists in database (replace the original)
				return View::make('user.dashboard.authentication')
				->with('schoolList', self::$schoolList)
				->with('majorCategoryList', self::$majorCategoryList)
				->with('majorList', self::$majorList)
				->with('error', 'File not uploaded!');
			} else {
				if (Input::hasFile('idcard_image')) {
					$file = Input::file('idcard_image');
					$fingerprint = md5(Auth::user()->id.Auth::user()->created_at);
					// dd($fingerprint);
					$file->move(public_path().'/upload', $fingerprint);
					User::where('id', Auth::user()->id)->update(['fingerprint'=>$fingerprint, 'authenticated'=>1]);
				} else {
					User::where('id', Auth::user()->id)->update(['authenticated'=>1]);
				}
			}
			User::where('id', Auth::user()->id)->update([
				'real_name'=>$userInput['real_name'],
				'school'=>$userInput['school'],
				'major_category'=>$userInput['major_category'],
				'major' => $userInput['major'],
				'enrollment_date'=>$userInput['enrollment_date'],
			]);
			return Redirect::to('/dashboard/authentication')
				->with('schoolList', self::$schoolList)
				->with('majorCategoryList', self::$majorCategoryList)
				->with('majorList', self::$majorList)
				->with('message', 'Save successfully!');
		} else {
			return Redirect::to('/dashboard/authentication')
				->with('schoolList', self::$schoolList)
				->with('majorCategoryList', self::$majorCategoryList)
				->with('majorList', self::$majorList)
				->withErrors($validator);
		}






		// if (strlen(Auth::user()->fingerprint) && !Input::hasFile('idcard_image')) {
		// 	return View::make('user.dashboard.authentication')->with('error', 'No file selected!');
		// }






		// FILE INPUT
		// $fileInput = [
		// 	'idcard_image'=>Input::file('idcard_image')
		// ];
		// $fileRules = [
		// 	'idcard_image'=>'required|mimes:jpeg,jpg,gif,bmp|max:1024'
		// ];
		// $fileValidator = Validator::make($fileInput, $fileRules);

		// if (!Input::hasFile('idcard_image') && !strlen(Auth::user()->fingerprint)) {
		// 	// file not uploaded
		// } else if($fileValidator->fails()) {
		// 	// filetype error
		// } else {
		// 	// when the file does not exist in database, insert it
		// 	dd('upload');
		// 	$file = Input::file('idcard_image');
		// 	$fingerprint = md5(Auth::user()->id.Auth::user()->created_at);
		// 	$file->move(public_path().'/upload', $fingerprint);
		// 	User::where('id', Auth::user()->id)->update(['fingerprint'=>$fingerprint]);
		// }



echo '<pre>';
var_dump($fileValidator->messages());
echo '</pre>';



		// return View::make('user.dashboard.authentication');
	}
}