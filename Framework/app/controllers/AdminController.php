<?php

class AdminController extends BaseController {
	public function auth() {
		$users = User::all();
		return View::make('admin.auth')
			->with('users', $users);
	}
	public function postAuth() {
		var_dump(Input::all());
	}
}