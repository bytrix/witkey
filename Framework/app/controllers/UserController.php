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

	public function profile($user_id) {

		$user = User::where('id', $user_id)->first();

		$schoolAge = Util::SecToYear(strtotime(date('Y-m-d')) - strtotime($user->enrollment_date));
		$grade = Util::getGrade($user, $schoolAge);

		return View::make('user.profile')
			->with('user', $user)
			->with('grade', $grade);
	}


	// POST
	public function postLogin() {

		$userInput = [
			'email'    => Input::get('email'),
			'password' => Input::get('password'),
		];

		$rules = [
			'email'    => 'required|email',
			'password' => 'required|between:6,20'
		];

		$validator = Validator::make($userInput, $rules);

		if($validator->passes()) {

			if(Auth::attempt($userInput)) {

				return Redirect::to('dashboard');

			} else {

				return View::make('user.login')
					->with('message', 'email or password is incorrect!');
			}

		} else {

			return Redirect::to('login')
				->withErrors($validator);
		}
	}

	public function postRegister() {


		echo '<pre>';
		var_dump(Input::all());
		echo '</pre>';

		$userInput = [
			'email'                 => Input::get('email'),
			'password'              => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation')
		];

		$rules = [
			'email'    => 'required|email|unique:User,email',
			'password' => 'required|between:6,20|confirmed',
		];

		$validator = Validator::make($userInput, $rules);

		if($validator->passes()) {

			$user           = new User;
			$user->username = rand();
			$user->password = $userInput['password'];
			$user->email    = $userInput['email'];
			$user->ip       = Request::ip();
			$user->city     = Util::getCity();
			$user->save();

			$avatar = md5('avatar' . $user->id . $user->created_at);
			$user->avatar = $avatar;

			// $avatarFile = Response::download(public_path() . '/assets/image/default_avatar/1.jpg', 'name');
			copy(public_path() . '/assets/image/default_avatar/' . rand(1, 12) . '.jpg', public_path() . '/avatar/' . $avatar);


			$user->save();
			Auth::login($user);
			return Redirect::to('dashboard');

		} else {
			
			return Redirect::to('register')->withErrors($validator);
		}

		return View::make('user.register');

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



// echo '<pre>';
// var_dump($fileValidator->messages());
// echo '</pre>';



		// return View::make('user.dashboard.authentication');
	// }
}