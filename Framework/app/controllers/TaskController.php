<?php


class TaskController extends BaseController {
	public function index() {
		return View::make('task.index');
	}

	public function edit($id) {
		$task = Task::where(['id'=>$id, 'user_id'=>Auth::user()->id])->first();
		return View::make('task.edit')->with('task', $task);
	}

	public function postEdit($id) {
		$task = Task::where('id', $id);
		$userInput = [
			'title'=>Input::get('title'),
			'detail'=>Input::get('detail')
		];
		$rules = [
			'title'=>'required',
			'detail'=>'required'
		];
		$validator = Validator::make($userInput, $rules);

		if ($validator->passes()) {
			$task->update([
				'title'=>Input::get('title'),
				'detail'=>Input::get('detail')
			]);
			return Redirect::to("/task/$id");
		} else {
			return Redirect::to("/task/$id/edit")->withErrors($validator);
		}

	}

	/*
	* DEMAND PUBLISHMENT IN 3 STEPS
	*/
	// 1. CREATE A DEMAND WITH TITLE AND DETAIL
	public function create() {
		return View::make('task.publish.create');
	}

	// 2. SET A REWARD AMOUNT FOR YOUR DEMAND
	public function setReward() {
		// dd(Session::get('title'), Session::get('detail'));
		// dd(Session::has('title') , Session::has('detail'));
		// if (!Session::has('title') || !Session::has('detail')) {
		// 	Session::set('title', Input::get('title'));
		// 	Session::set('detail', Input::get('detail'));
		// }
		// var_dump(Request::method());
		if (Request::method() == "POST") {
			$userInput = [
				'title'=>Input::get('title'),
				'detail'=>Input::get('detail')
			];
		} else {
			$userInput = [
				'title'=>Session::get('title'),
				'detail'=>Session::get('detail')
			];
			// dd(Session::get('title'));
		}
		$rules = [
			'title'=>'required',
			'detail'=>'required'
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			Session::set('title', $userInput['title']);
			Session::set('detail', $userInput['detail']);
			return View::make('task.publish.set-reward');
		} else {
			return Redirect::to('/demand/new')->withErrors($validator);
		}
	}

	// 3. VALIDATE THE USER INPUT AND INSERT INTO DATABASE
	public function bill() {

		Validator::extend('positive', function($attribute, $value, $parameters) {
			// dd($value);
			if ($value <= 0) {
				return false;
			} else {
				return true;
			}
		},"This amount field need to be positive");
		// if (!Session::has('amount') || !Session::has('expiration')) {
		// 	Session::set('amount', Input::get('amount'));
		// 	Session::set('expiration', Input::get('expiration'));
		// }
		if (Request::method() == "POST") {
			$userInput = [
				'amount'=>Input::get('amount'),
				'expiration'=>Input::get('expiration')
			];
		} else {
			// dd('get');
			$userInput = [
				'amount'=>Session::get('amount'),
				'expiration'=>Session::get('expiration')
			];
		}
		$rules = [
			'amount'=>'required|numeric|positive',
			'expiration'=>'required|date'
		];
		$validator = Validator::make($userInput, $rules);
		// dd($userInput);
		if ($validator->passes()) {
			Session::set('amount', $userInput['amount']);
			Session::set('expiration', $userInput['expiration']);
			return View::make('task.publish.bill');
		} else {
			return Redirect::back()->withErrors($validator);
		}
	}

	public function postTask() {
		// dd(var_dump(Session::all()));
		$task = new Task;
		$task->user_id = Auth::user()->id;
		$task->title = Session::get('title');
		$task->detail = Session::get('detail');
		$task->amount = Session::get('amount');
		$task->expiration = Session::get('expiration');
		$task->save();
		$credit = Auth::user()->credit;
		User::where('id', Auth::user()->id)->update(['credit'=>($credit - 50)]);
		Session::forget('title');
		Session::forget('detail');
		Session::forget('amount');
		Session::forget('expiration');
		return Redirect::to('task/list');
	}

	public function listTask() {
		$tasks = Task::orderBy('created_at', 'desc')->paginate(10);
		return View::make('task.list')->with('tasks', $tasks);
	}

	public function detail($id) {
		$task = Task::where('id', $id)->first();
		return View::make('task.detail')->with('id', $id)->with('task', $task);
	}


	public function enrollment($id) {
		$isBidder = Auth::user()->isBidder($id);
		if (!$isBidder) {
			$task_bidder = new TaskBidder;
			$task_bidder->task_id = $id;
			$task_bidder->bidder_id = Auth::user()->id;
			$task_bidder->save();
		}
		return Redirect::to("/task/$id");
	}

	public function quit($id) {
		$isBidder = Auth::user()->isBidder($id);
		if ($isBidder) {
			$task_bidder = TaskBidder::where(['task_id'=>$id, 'bidder_id'=>Auth::user()->id]);
			$task_bidder->delete();
			// $task_bidder = new TaskBidder;
			// $task_bidder->task_id = $id;
			// $task_bidder->bidder_id = Auth::user()->id;
			// $task_bidder->save();
		}
		return Redirect::to("/task/$id");
	}



	public function favorite($tid) {
		// return $tid;
		// $taskfavorite_user = TaskfavoriteUser::create(['task_favoriteed_id'=>$tid, 'user_id'=>Auth::user()->id]);
		$taskfavorite_user = new TaskfavoriteUser;
		$taskfavorite_user->task_favorite_id = $tid;
		$taskfavorite_user->user_id = Auth::user()->id;
		$taskfavorite_user->save();
		return 'ok';
	}

}