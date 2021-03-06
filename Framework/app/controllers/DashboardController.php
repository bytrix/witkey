<?php

class DashboardController extends BaseController {

	public function setUsername() {
		$userInput = [
			'username' => Input::get('username')
		];
		$rule = [
			'username' => 'required'
		];
		$validator = Validator::make($userInput, $rule);
		if ($validator->passes()) {
			$user = User::where('id', Auth::user()->id)->first();
			$user->username = $userInput['username'];
			$user->random_name = false;
			$user->save();
			return Redirect::to('/dashboard');
		} else {
			return Redirect::to('/dashboard')
				->withErrors($validator);
		}
	}

	public function overview() {

		$h = date('H');
		$greeting = '你好';

		if ($h>=0 && $h<5) {
			$greeting = $greeting;

		} else if($h>=5 && $h<11) {
			$greeting = '早上好';

		} else if($h>=11 && $h<13) {
			$greeting = '中午好';

		} else if($h>=13 && $h<18) {
			$greeting = '下午好';

		} else if($h>=18 && $h<24) {
			$greeting = '晚上好';
		}

		$orders = Auth::user()->order()->paginate(5);

		return View::make('dashboard.overview')
			->with('greeting', $greeting)
			->with('orders', $orders);
	}

	public function myProfile() {
		return View::make('dashboard.myProfile');
	}

	public function changeAvatar() {
		return View::make('dashboard.changeAvatar');
	}


	public function taskOrder() {
		$orders = Auth::user()->order()->paginate(10);
		return View::make('dashboard.taskOrder')
			->with('orders', $orders);
	}

	// public function postcard() {
	// 	return View::make('user.dashboard.postcard');
	// }

	public function favoriteTask() {

		$favoriteTasks = Auth::user()->favoriteTask;

		return View::make('dashboard.favoriteTask')
			->with('favoriteTasks', $favoriteTasks);
	}

	public function myFriends() {

		$friends = Auth::user()->friend;
		
		return View::make('dashboard.myFriends')
			->with('friends', $friends);
	}

	public function authentication() {

		$schoolList = array();
		$majorList = array();

		// foreach (Academy::all() as $school) {
		// 	array_push($schoolList, $school->name);
		// }

		return View::make('dashboard.authentication')
			->with('schoolList'       , $schoolList)
			->with('majorList'        , $majorList);
	}

	public function paySetting() {
		return View::make('dashboard.paySetting');
	}

	public function security() {
		return View::make('dashboard.security');
	}


	public function postMyProfile() {
		// echo '<pre>';
		// dd(var_dump(Input::all()));
		// echo '</pre>';
		// if (isset($_POST["croppedCanvas"])) {
		// 	// $category = new Category;
		// 	// $category->name = $_POST["croppedCanvas"];
		// 	// $category->save();
		// 	$croppedCanvas = $_POST["croppedCanvas"];


		// 	 $croppedCanvas = str_replace('data:image/png;base64,', '', $croppedCanvas);
		// 	 $croppedCanvas = str_replace(' ', '+', $croppedCanvas);
		// 	 $data = base64_decode($croppedCanvas);


		// 	file_put_contents(public_path() . '/avatar/' . Auth::user()->avatar, $data);
		// }
		// dd(Input::all());
		$userModify = [
			'username'  => Input::get('username'),
			'gender'    => Input::get('gender'),
			'email'       => Input::get('email'),
			'qq'        => Input::get('qq'),
			'dorm'      => Input::get('dorm_state') == 'no' ? 'no' : Input::get('dorm'),
			'biography' => Input::get('biography'),
			'skill_tag' => Input::get('skill_tag'),
		];
		if (Input::get('email') == Auth::user()->email) {
			unset($userModify['email']);
		}

		$rules = [
			'email' => 'email|unique:User,email',
		];

		$validator = Validator::make($userModify, $rules);

		if ($validator->passes()) {
			if ($userModify['username'] != Auth::user()->username) {
				User::where('id', Auth::user()->id)
					->update(['random_name'=>false]);
			}
			User::where('id', Auth::user()->id)
				->update($userModify);

			return Redirect::to('dashboard/myProfile')
				->with('message', Lang::get('message.data-has-been-saved-successfully'));
		} else {
			// TODO...
			// Redirect to with message
			return 'email not unique';
		}
	}

	public function postAvatar() {
			// dd('ss');
		if (isset($_POST["croppedCanvas"])) {
			// $category = new Category;
			// $category->name = $_POST["croppedCanvas"];
			// $category->save();
			$croppedCanvas = $_POST["croppedCanvas"];


			 $croppedCanvas = str_replace('data:image/png;base64,', '', $croppedCanvas);
			 $croppedCanvas = str_replace(' ', '+', $croppedCanvas);
			 $data = base64_decode($croppedCanvas);


			file_put_contents(public_path() . '/avatar/' . Auth::user()->avatar, $data);
		}
		// dd(Input::all());
		// $userModify = [
		// 	'username'  => Input::get('username'),
		// 	'gender'    => Input::get('gender'),
		// 	'tel'       => Input::get('tel'),
		// 	'qq'        => Input::get('qq'),
		// 	'dorm'      => Input::get('dorm_state') == 'no' ? 'no' : Input::get('dorm'),
		// 	'biography' => Input::get('biography'),
		// 	'skill_tag' => Input::get('skill_tag'),
		// ];

		// User::where('id', Auth::user()->id)
		// 	->update($userModify);

		return Redirect::to('dashboard/changeAvatar')
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
				->with('error', Lang::get('message.password-incorrect'));
		}

		return View::make('dashboard.security');
	}

	public function postAuthentication() {

		// dd(Input::all());
		// TEXT INPUT
		$userInput = [
			'truename'        => Input::get('truename'),
			'school'          => Input::get('school'),
			'idcard_image'    => Input::file('idcard_image'),
			'major'           => Input::get('major'),
			'enrollment_date' => Input::get('enrollment_date'),
		];

		$rules = [
			'truename'        => 'required',
			'school'          => 'required',
			'idcard_image'    => 'mimes:jpeg,jpg,gif,bmp,png|max:1024',
			'major'           => 'required',
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

				return View::make('dashboard.authentication')
					// ->with('schoolList'       , Academy::allAcademies())
					// ->with('majorList'        , Academy::allMajors())
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

				'truename'        => $userInput['truename'],
				'school'          => $userInput['school'],
				'major'           => $userInput['major'],
				'enrollment_date' => $userInput['enrollment_date'],

			]);

			return Redirect::to('/dashboard/authentication')
				// ->with('schoolList'       , Academy::allAcademies())
				// ->with('majorList'        , Academy::allMajors())
				->with('message'          , Lang::get('message.data-has-been-saved-successfully'));

		} else {

			return Redirect::to('/dashboard/authentication')
				// ->with('schoolList'       , Academy::allAcademies())
				// ->with('majorList'        , Academy::allMajors())
				->withErrors($validator);
		}
	}

	public function postPaySetting() {
		// var_dump(Input::all());
		// var_dump(Input::has('alipay_account'));
		// dd();
		if (Input::has('alipay_account')) {
			$user = Auth::user();
			$user->alipay_account = Input::get('alipay_account');
			$user->save();
			return Redirect::to('/dashboard/pay-setting')
				->with('message', Lang::get('message.data-has-been-saved-successfully'));
		} else {
			echo 'NO OPTION SELECTED!';
		}
	}

	public function rate($task_id) {

		$task = Task::where('id', $task_id)->first();

		$winningCommit = CommitPivot::where('id', $task->winning_commit_id)->first();

		$winner = User::where('id', $winningCommit->user->id)->first();

		return View::make('dashboard.rate')
			->with('task', $task)
			->with('winner', $winner);
	}

	public function postRate($task_id) {
		$task = Task::where('id', $task_id)->first();
		$comment = new Comment;
		$userInput = [
			'user_id' => Input::get('user_id'),
			'star' => Input::get('star'),
			'content' => Input::get('content'),
			'from_whom_id' => $task->user->id
		];
		$rules = [
			'content' => 'required'
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			$comment->from_whom_id = $userInput['from_whom_id'];
			$comment->user_id = $userInput['user_id'];
			$comment->star = $userInput['star'];
			$comment->content = $userInput['content'];
			$comment->save();
			CommitPivot::where('id', $task->winning_commit_id)->update(['comment_id'=>$comment->id]);
			return Redirect::to('dashboard/taskOrder');
		} else {
			return Redirect::to("/dashboard/rate/$task_id")
				->withErrors($validator);
		}

	}

}