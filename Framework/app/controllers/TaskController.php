<?php


class TaskController extends BaseController {
	public function index() {





		return View::make('task.index');
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

	// 3. VALIexpire THE USER INPUT AND INSERT INTO DATABASE
	public function bill() {

		Validator::extend('positive', function($attribute, $value, $parameters) {
			// dd($value);
			if ($value <= 0) {
				return false;
			} else {
				return true;
			}
		},"This amount field need to be positive");
		// if (!Session::has('amount') || !Session::has('expire')) {
		// 	Session::set('amount', Input::get('amount'));
		// 	Session::set('expire', Input::get('expire'));
		// }
		if (Request::method() == "POST") {
			$userInput = [
				'amount'=>Input::get('amount'),
				'expire'=>Input::get('expire')
			];
		} else {
			// dd('get');
			$userInput = [
				'amount'=>Session::get('amount'),
				'expire'=>Session::get('expire')
			];
		}
		$rules = [
			'amount'=>'required|numeric|positive',
			'expire'=>'required|date'
		];
		$validator = Validator::make($userInput, $rules);
		// dd($userInput);
		if ($validator->passes()) {
			Session::set('amount', $userInput['amount']);
			Session::set('expire', $userInput['expire']);
			return View::make('task.publish.bill');
		} else {
			return Redirect::back()->withErrors($validator);
		}
	}

	public function postDemand() {
		$task = new Task;
		$task->user_id = Auth::user()->id;
		$task->title = Session::get('title');
		$task->detail = Session::get('detail');
		$task->amount = Session::get('amount');
		$task->expire = Session::get('expire');
		$task->save();
		Session::forget('title');
		Session::forget('detail');
		Session::forget('amount');
		Session::forget('expire');
		return Redirect::to('task/list');
	}

	public function listTask() {
		$tasks = Task::orderBy('created_at', 'desc')->get();
		return View::make('task.list')->with('tasks', $tasks);
	}

	public function detail($id) {
		$task = Task::where('id', $id)->first();
		return View::make('task.detail')->with('id', $id)->with('task', $task);
	}


	public function enrollment($id) {
		$whetherEnroll = Auth::user()->whetherEnroll($id);
		if (!$whetherEnroll) {
			$task_bidder = new TaskBidder;
			$task_bidder->task_id = $id;
			$task_bidder->bidder_id = Auth::user()->id;
			$task_bidder->save();
		}
		return Redirect::to("/task/$id");
	}

	public function quit($id) {
		$whetherEnroll = Auth::user()->whetherEnroll($id);
		if ($whetherEnroll) {
			$task_bidder = TaskBidder::where(['task_id'=>$id, 'bidder_id'=>Auth::user()->id]);
			$task_bidder->delete();
			// $task_bidder = new TaskBidder;
			// $task_bidder->task_id = $id;
			// $task_bidder->bidder_id = Auth::user()->id;
			// $task_bidder->save();
		}
		return Redirect::to("/task/$id");
	}

}