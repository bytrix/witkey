<?php

class UserController extends BaseController {


	public static function get_gravatar( $email, $s = 200, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
		$url = 'http://www.gravatar.com/avatar/';
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



		// dd($this->get_gravatar('wengzhijie@126.com'));


		return View::make('user.dashboard.overview')->with('greeting', $greeting)->with('gravatar_path', $this->get_gravatar(Auth::user()->email));
	}

	public function profile() {
		return View::make('user.dashboard.profile');
	}


	public function myDemands() {
		return View::make('user.dashboard.myDemands');
	}

	public function authentication() {
		return View::make('user.dashboard.authentication');
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
			$user->save();
			Auth::login($user, true);
			return Redirect::to('dashboard');
		} else {
			return Redirect::to('register')->withErrors($validator);
		}

		return View::make('user.register');

	}

	public function postProfile() {
		$userModify = [
			'username'=>Input::get('username'),
			'gender'=>Input::get('gender'),
			'tel'=>Input::get('tel'),
			'dorm'=>Input::get('dorm')
		];
		User::where('id', Auth::user()->id)->update($userModify);
		return Redirect::to('dashboard/profile')->with('message', 'Username has been saved successfully!');
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

		// var_dump(empty(Auth::user()->identify_card));


		// TEXT INPUT
		$userInput = [
			'real_name'=>Input::get('real_name'),
			'school'=>Input::get('school'),
			'idcard_image'=>Input::file('idcard_image')
		];
		$rules = [
			'real_name'=>'required',
			'school'=>'required',
			'idcard_image'=>'mimes:jpeg,jpg,gif,bmp|max:1024'
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
			User::where('id', Auth::user()->id)->update(['real_name'=>$userInput['real_name'], 'school'=>$userInput['school']]);
			if (!Input::hasFile('idcard_image') && !strlen(Auth::user()->identity_card)) {	// when the file exists in database (replace the original)
				return View::make('user.dashboard.authentication')->with('error', 'File not uploaded!');
			} else {
				if (Input::hasFile('idcard_image')) {
					$file = Input::file('idcard_image');
					$fingerprint = md5(Auth::user()->id.Auth::user()->created_at);
					// dd($fingerprint);
					$file->move(public_path().'/upload', $fingerprint);
					User::where('id', Auth::user()->id)->update(['identity_card'=>$fingerprint, 'authenticated'=>1]);
				}
			}
			return Redirect::to('/dashboard/authentication')->with('message', 'Save successfully!');
		} else {
			return Redirect::to('/dashboard/authentication')->withErrors($validator);
		}






		// if (strlen(Auth::user()->identity_card) && !Input::hasFile('idcard_image')) {
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

		// if (!Input::hasFile('idcard_image') && !strlen(Auth::user()->identity_card)) {
		// 	// file not uploaded
		// } else if($fileValidator->fails()) {
		// 	// filetype error
		// } else {
		// 	// when the file does not exist in database, insert it
		// 	dd('upload');
		// 	$file = Input::file('idcard_image');
		// 	$fingerprint = md5(Auth::user()->id.Auth::user()->created_at);
		// 	$file->move(public_path().'/upload', $fingerprint);
		// 	User::where('id', Auth::user()->id)->update(['identity_card'=>$fingerprint]);
		// }



echo '<pre>';
var_dump($fileValidator->messages());
echo '</pre>';



		// return View::make('user.dashboard.authentication');
	}
}