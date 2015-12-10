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
		Session::set('title', Input::get('title'));
		Session::set('detail', Input::get('detail'));
		return View::make('task.publish.set-reward');
	}

	// 3. VALIDATE THE USER INPUT AND INSERT INTO DATABASE
	public function bill() {
		Session::set('amount', Input::get('amount'));
		Session::set('expire', Input::get('date'));
		return View::make('task.publish.bill');
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