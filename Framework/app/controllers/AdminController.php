<?php

class AdminController extends BaseController {

	public function home() {
		// if (Auth::user()->permission == 1 || Auth::user()->permission == 3) {
		// 	return View::make('admin.home');
		// } else {
		// 	return 'You are not admin!';
		// }
		return View::make('admin.home');
		// var_dump(Auth::user());
	}

	public function login() {
		return View::make('admin.login');
	}

	public function postLogin() {
		$password = Input::get('password');
		$secret = 'NzZjODY2ND';
		if ($password == $secret) {
			Session::put('secret', $secret);
			return Redirect::to('/myadmin');
		} else {
			return Redirect::to('/myadmin/login')
				->with('message', 'wrong password');
		}
	}

	public function quit() {
		Session::forget('secret');
		return Redirect::back();
	}

	public function auth() {
		return View::make('admin.auth');
	}


	public function studentCardPreview($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		return View::make('admin.studentCardPreview')
			->with('user_id', $user_id)
			->with('user', $user);
		return Redirect::back();
	}





	public function academy() {
		$academies = Academy::orderBy('created_at', 'desc')->get();
		return View::make('admin.academy')
			->with('academies', $academies);
	}

	public function postAcademy() {
		$userInput = [
			'name' => Input::get('name')
		];
		$rules = [
			'name' => 'required'
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			$academy = new Academy;
			$academy->name = $userInput['name'];
			$academy->save();
			return Redirect::to('/admin/academy');
		} else {
			return Redirect::to('/admin/academy')
				->withErrors($validator);
		}
	}


	public function academyDetail($academy_id) {
		$academy = Academy::where('id', $academy_id)->first();
		$majors = $academy->major;
		return View::make('admin.academyDetail')
			->with('academy', $academy)
			->with('majors', $majors);
	}

	public function postMajor($academy_id) {
		$userInput = [
			'name' => Input::get('major_name'),
			'academy_id' => $academy_id
		];
		$rules = [
			'name' => 'required',
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			$major = new Major();
			$major->name = $userInput['name'];
			$major->academy_id = $userInput['academy_id'];
			$major->save();
			return Redirect::to("/admin/academy/$academy_id");
		} else {
			return Redirect::to("/admin/academy/$academy_id")
				->withErrors($validator);
		}

	}


	public function permission() {
		$users = User::all();
		return View::make('admin.permission')
			->with('users', $users);
	}

	public function chmod($user_id, $permission) {
		if ($user_id != 1) {
			$user = User::where('id', $user_id)->first();
			if ($user->authenticated == 2) {
				$user->permission = $permission;
				$user->save();
			}
		}
		return Redirect::back();
	}

	public function order() {

		$orders = Task::orderBy('created_at', 'desc')->get();
		$unpaid_orders_num = count(Task::where('state', 4)->get());

		return View::make('admin.taskOrder')
			->with('orders', $orders)
			->with('unpaid_orders_num', $unpaid_orders_num);
	}

	public function postOrder() {

		$task_ids = explode(',', Input::get('taskIds'));

		foreach ($task_ids as $task_id) {
			$task = Task::where('id', $task_id)->first();
			$winning_commit = $task->winningCommit;
			echo $winning_commit->user->alipay_account;
			echo '<br />';
		}
		
	}

}