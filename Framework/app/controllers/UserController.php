<?php

class UserController extends BaseController {
	
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
		return View::make('user.dashboard.overview');
	}

	public function profile() {
		return View::make('user.dashboard.profile');
	}


	public function mytask() {
		return View::make('user.dashboard.mytask');
	}

	public function certification() {
		return View::make('user.dashboard.certification');
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

	public function postCertification() {
		$userInput = [
			'real_name'=>Input::get('real_name'),
			'school'=>Input::get('school')
		];
		$rules = [
			'real_name'=>'required',
			'school'=>'required'
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			User::where('id', Auth::user()->id)->update(['real_name'=>$userInput['real_name'], 'school'=>$userInput['school']]);
			if (Input::hasFile('idcard_image')) {
				$file = Input::file('idcard_image');
				$fingerprint = md5(Auth::user()->id.Auth::user()->created_at);
				$file->move(public_path().'/upload', $fingerprint);
				User::where('id', Auth::user()->id)->update(['identify_card'=>$fingerprint]);
			}
			return Redirect::to('/dashboard/certification')->with('message', 'Save successfully!');
		} else {
			return Redirect::to('/dashboard/certification')->withErrors($validator);
		}
		// return View::make('user.dashboard.certification');
	}
}