<?php

class AdminController extends BaseController {
	public function auth() {
		$users = User::all();
		return View::make('admin.auth')
			->with('users', $users);
	}

	public function getAuth() {
		return User::all();
	}

	public function postAuthTobe($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		$user->authenticated = 1;
		$user->save();
	}

	public function postAuthSuccess($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		$user->authenticated = 2;
		$user->save();
	}

	public function postAuthFail($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		$user->authenticated = 3;
		$user->save();
	}
}