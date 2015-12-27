<?php

class AdminController extends BaseController {
	public function auth() {
		return View::make('admin.auth');
	}

	public function getAuth() {
		return User::orderBy('authenticated')->get();
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