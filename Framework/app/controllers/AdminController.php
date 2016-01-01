<?php

class AdminController extends BaseController {
	public function auth() {
		return View::make('admin.auth');
	}

	public function getUsers() {
		return User::orderBy('authenticated')->get([
				'id',
				'authenticated',
				'realname',
				'username',
				'email',
				'student_card',
				'school',
				'major',
				'enrollment_date'
			]);
	}

	public function postAuthTobe($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		if ($user->authenticated != 0) {
			$user->authenticated = 1;
			$user->save();
		}
		return Redirect::back();
	}

	public function postAuthSuccess($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		if ($user->authenticated != 0) {
			$user->authenticated = 2;
			$user->save();
		}
		return Redirect::back();
	}

	public function postAuthFail($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		if ($user->authenticated != 0) {
			$user->authenticated = 3;
			$user->save();
		}
		return Redirect::back();
	}

	public function student_card($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		return View::make('admin.student_card')
			->with('user_id', $user_id)
			->with('user', $user);
		return Redirect::back();
	}
}