<?php

class TaskController extends BaseController {
	public function index() {
		return View::make('task.index');
	}

	/*
	* TASK PUBLISHMENT IN 3 STEPS
	*/
	// 1. CREATE A TASK WITH TITLE AND DETAIL
	public function create() {
		return View::make('task.publish.create');
	}

	// 2. SET A REWARD AMOUNT FOR YOUR TASK
	public function setReward() {
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
			Session::set('title', Input::get('title'));
			Session::set('detail', Input::get('detail'));
			return View::make('task.publish.set-reward');
		} else {
			return Redirect::to('/task/new')->withErrors($validator);
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
		$userInput = [
			'amount'=>Input::get('amount'),
			'expire'=>Input::get('date')
		];
		$rules = [
			'amount'=>'required|numeric|positive',
			'expire'=>'required|date'
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			Session::set('amount', Input::get('amount'));
			Session::set('expire', Input::get('date'));
			return View::make('task.publish.bill');
		} else {
			return Redirect::back()->withErrors($validator);
		}
	}

	public function postTask() {
		$task = new Task;
		$task->user_id = Auth::user()->id;
		$task->title = Session::get('title');
		$task->detail = Session::get('detail');
		$task->amount = Session::get('amount');
		$task->expire = Session::get('expire');
		$task->save();
		return Redirect::to('task/list');
	}

	public function listTask() {
		$tasks = Task::orderBy('created_at', 'desc')->get();
		return View::make('task.list')->with('tasks', $tasks);
	}

	public function detail($id) {
		$task = Task::where('id', $id)->first();
		return View::make('task.detail')->with('task', $task);
	}

}