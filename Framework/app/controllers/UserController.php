<?php

class UserController extends BaseController {
	
	// get
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

	public function dashboard() {
		return View::make('user.dashboard.profile');
	}

	public function mytask() {
		return View::make('user.dashboard.mytask');
	}

	public function security() {
		return View::make('user.dashboard.security');
	}


	// post
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
}