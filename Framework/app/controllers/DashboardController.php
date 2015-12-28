<?php

class DashboardController extends BaseController {

	public function overview() {

		$h = date('H');
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

		return View::make('dashboard.overview')
			->with('greeting', $greeting);
	}

	public function myProfile() {
		return View::make('dashboard.myProfile');
	}


	public function taskOrder() {
		return View::make('dashboard.taskOrder');
	}

	// public function postcard() {
	// 	return View::make('user.dashboard.postcard');
	// }

	public function favoriteTask() {

		$favoriteTask = Auth::user()->favoriteTask();

		return View::make('dashboard.favoriteTask')
			->with('favoriteTask', $favoriteTask);
	}

	public function authentication() {

		return View::make('dashboard.authentication')
			->with('schoolList'       , Academy::allAcademies())
			->with('majorCategoryList', Academy::allMajors())
			->with('majorList'        , Academy::allMajors());
	}

	public function security() {
		return View::make('dashboard.security');
	}


	public function postMyProfile() {
		// dd(Input::all());
		$userModify = [
			'username'  => Input::get('username'),
			'gender'    => Input::get('gender'),
			'tel'       => Input::get('tel'),
			'qq'        => Input::get('qq'),
			'dorm'      => Input::get('dorm_state') == 'no' ? 'no' : Input::get('dorm'),
			'skill_tag' => Input::get('skill_tag'),
		];

		User::where('id', Auth::user()->id)
			->update($userModify);

		return Redirect::to('dashboard/myProfile')
			->with('message', 'Data has been saved successfully!');
	}

	public function postSecurity() {

		$oldPasswordMatches = Hash::check(Input::get('old_password'), Auth::user()->password);

		if($oldPasswordMatches) {
			// Set a new password
			$userInput = [
				'password'              => Input::get('password'),
				'password_confirmation' => Input::get('password_confirmation')
			];

			$rules = [
				'password'=>'required|between:6,20|confirmed'
			];

			$validator = Validator::make($userInput, $rules);

			if($validator->passes()) {

				User::where('id', Auth::user()->id)
					->update(['password'=>Hash::make($userInput['password'])]);

				return View::make('dashboard.security')
					->with('message', 'Password set successfully!');

			} else {

				return Redirect::to('dashboard/security')
					->withErrors($validator);
			}
		} else {

			return View::make('dashboard.security')
				->with('error', 'The password is incorrect!');
		}

		return View::make('dashboard.security');
	}

	public function postAuthentication() {
		// dd(var_dump(Input::all()));
		// $major = [
		// 	'majorCategory'=>self::$majorCategoryList[Input::get('major_category')],
		// 	'majorName'=>self::$majorList[Input::get('major')]
		// ];
		// TEXT INPUT
		$userInput = [
			'realname'        => Input::get('realname'),
			'school'          => Input::get('school'),
			'idcard_image'    => Input::file('idcard_image'),
			// 'major_category'  => Input::get('major_category'),
			'major'      => Input::get('major'),
			'enrollment_date' => Input::get('enrollment_date'),
		];

		$rules = [
			'realname'        => 'required',
			'school'          => 'required',
			'idcard_image'    => 'mimes:jpeg,jpg,gif,bmp,png|max:1024',
			// 'major_category'  => 'required',
			'major'      => 'required',
			'enrollment_date' => 'required',
		];

		$validator = Validator::make($userInput, $rules);

		// FILE INPUT
		// $fileInput = [
		// 	'idcard_image'=> Input::file('idcard_image')
		// ];
		// $fileRules = [
		// 	'idcard_image'=>'required|mimes:jpeg,jpg,gif,bmp|max:1024'
		// ];
		// $fileValidator = Validator::make($fileInput, $fileRules);

		if ($validator->passes()) {

			if (!Input::hasFile('idcard_image') && !strlen(Auth::user()->student_card)) {
			// when the file exists in database (replace the original)

				return View::make('user.dashboard.authentication')
					->with('schoolList'       , self::$schoolList)
					->with('majorCategoryList', self::$majorCategoryList)
					->with('majorList'        , self::$majorList)
					->with('error'            , 'File not uploaded!');

			} else {

				if (Input::hasFile('idcard_image')) {

					$file        = Input::file('idcard_image');
					$student_card = md5('student_card' . Auth::user()->id.Auth::user()->created_at);

					$file->move(public_path() . '/student_card', $student_card);

					User::where('id', Auth::user()->id)
						->update(['student_card'=>$student_card, 'authenticated'=>1]);

				} else {

					User::where('id', Auth::user()->id)
						->update(['authenticated'=>1]);

				}
			}

			User::where('id', Auth::user()->id)->update([

				'realname'       => $userInput['realname'],
				'school'          => $userInput['school'],
				// 'major_category'  => $userInput['major_category'],
				'major'      => $userInput['major'],
				'enrollment_date' => $userInput['enrollment_date'],

			]);

			return Redirect::to('/dashboard/authentication')
				->with('schoolList'       , Academy::allAcademies())
				->with('majorCategoryList', Academy::allMajors())
				->with('majorList'        , UserController::$majorList)
				->with('message'          , 'Save successfully!');

		} else {

			return Redirect::to('/dashboard/authentication')
				->with('schoolList'       , Academy::allAcademies())
				->with('majorCategoryList', Academy::allMajors())
				->with('majorList'        , UserController::$majorList)
				->withErrors($validator);
		}
	}

}