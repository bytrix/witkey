<?php


class TaskController extends BaseController {


	public function edit($task_id) {

		$task = Task::where([
			'id'      => $task_id,
			'user_id' => Auth::user()->id
		])->first();

		return View::make('task.edit')->with('task', $task);

	}

	/*
	* DEMAND PUBLISHMENT IN 3 STEPS
	*/

	// 1. CREATE A DEMAND WITH TITLE AND DETAIL
	public function step_1() {
		return View::make('task.publish.step_1');
	}

	// 2. SET A REWARD AMOUNT FOR YOUR DEMAND
	public function step_2() {

		if (Request::method() == "POST") {
			$userInput = [
				'title'  => Input::get('title'),
				'detail' => Input::get('detail')
			];
		} else {
			$userInput = [
				'title'  => Session::get('title'),
				'detail' => Session::get('detail')
			];
		}

		$rules = [
			'title'  => 'required',
			'detail' => 'required'
		];

		$validator = Validator::make($userInput, $rules);

		if ($validator->passes()) {

			Session::set('title' , $userInput['title']);
			Session::set('detail', $userInput['detail']);
			return View::make('task.publish.step_2');

		} else {

			return Redirect::to('/task/create')->withErrors($validator);
		}
	}

	// 3. VALIDATE THE USER INPUT AND INSERT INTO DATABASE
	public function step_3() {

		Validator::extend('positive', function($attribute, $value, $parameters) {

			if ($value < 0) {
				return false;
			} else {
				return true;
			}

		},"This amount field cannot be negative");
		// if (!Session::has('amount') || !Session::has('expiration')) {
		// 	Session::set('amount', Input::get('amount'));
		// 	Session::set('expiration', Input::get('expiration'));
		// }
		if (Request::method() == "POST") {

			$userInput = [
				'type'       => Input::get('type'),
				'amount'     => Input::get('amount', 0),
				'expiration' => Input::get('expiration')
			];

		} else {

			$userInput = [
				'type'       => Session::get('type'),
				'amount'     => Session::get('amount'),
				'expiration' => Session::get('expiration')
			];

		}

		$rules = [
			'type'       => 'required',
			'amount'     => 'required|numeric|positive',
			'expiration' => 'required|date'
		];

		$validator = Validator::make($userInput, $rules);
		// dd($userInput);
		if ($validator->passes()) {

			Session::set('type'      , $userInput['type']);
			Session::set('amount'    , $userInput['amount']);
			Session::set('expiration', $userInput['expiration']);
			
			return View::make('task.publish.step_3');

		} else {

			return Redirect::back()->withErrors($validator);
		}
	}


	public function listTask() {

		$tasks = Task::orderBy('created_at', 'desc')
			->paginate(10);

		return View::make('task.list')
			->with('tasks', $tasks);
	}

	public function detail($task_id) {


		$task = Task::where('id', $task_id)->first();

		if ($task->user->active == 0) {
			return View::make('task.closed');
		}


		if (Auth::check()) {
			if ($task->type ==1) {
				// dd(var_dump($task->user_id == Auth::user()->id));
				Session::set('commit_sum', count(CommitPivot::where(['task_id'=>$task_id])->get()));
				if ($task->user_id == Auth::user()->id) {
					$all_commits = CommitPivot::where(['task_id'=>$task_id]);
				} else {
					// dd(var_dump(Auth::user()->isBidder($task_id)));
					if (Auth::user()->isBidder($task_id)) {
						$all_commits = CommitPivot::where(['task_id'=>$task_id, 'user_id'=>Auth::user()->id]);
					} else {
						return View::make('task.detail')
							->with('task_id', $task_id)
							->with('task', $task);
					}
				}
				$commits = $all_commits->orderBy('created_at', 'desc')->paginate(5);
				return View::make('task.detail')
					->with('task_id', $task_id)
					->with('task', $task)
					->with('commits', $commits);

			} else if($task->type ==2) {
				$quote = QuotePivot::where(['task_id'=>$task_id])->paginate(5);
				return View::make('task.detail')
					->with('task_id', $task_id)
					->with('task', $task)
					->with('quotes', $quotes);

			}
		}



		return View::make('task.detail')
			->with('task_id', $task_id)
			->with('task', $task);

	}



	public function postEdit($task_id) {

		$task = Task::where('id', $task_id);

		$userInput = [
			'title'  => Input::get('title'),
			'detail' => Input::get('detail')
		];

		$rules = [
			'title'  => 'required',
			'detail' => 'required'
		];

		$validator = Validator::make($userInput, $rules);

		if ($validator->passes()) {

			$task->update([
				'title'  => Input::get('title'),
				'detail' => Input::get('detail')
			]);

			return Redirect::to("/task/$task_id");

		} else {

			return Redirect::to("/task/$task_id/edit")->withErrors($validator);

		}

	}



	public function postCreate() {

		$task             = new Task;
		$task->user_id    = Auth::user()->id;
		$task->type       = Session::get('type');
		$task->title      = Session::get('title');
		$task->detail     = Session::get('detail');
		$task->amount     = Session::get('amount');
		$task->expiration = Session::get('expiration');
		$task->save();
		$credit = Auth::user()->credit;

		User::where('id', Auth::user()->id)
			->update(['credit' => ($credit - 50)]);

		Session::forget('title');
		Session::forget('detail');
		Session::forget('amount');
		Session::forget('expiration');

		return Redirect::to('task/list');
	}


	public function postCommit($task_id) {
		// header('content-type:charset=utf-8');
		// dd(Input::all());
		$userInput = [
			'summary' => Input::get('summary'),
		];
		$rules = [
			'summary' => 'required',
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			$commit = new CommitPivot;
			$commit->task_id = $task_id;
			$commit->user_id = Auth::user()->id;
			$commit->summary = Input::get('summary');
			$commit->save();
			return Redirect::to("/task/$task_id");
		} else {
			return Redirect::to("/task/$task_id")
				->withErrors($validator);
		}
	}

	public function postQuote($task_id) {
		$userInput = [
			'summary' => Input::get('summary'),
		];
		$rules = [
			'summary' => 'required',
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			$quote = new QuotePivot;
			$quote->task_id = $task_id;
			$quote->user_id = Auth::user()->id;
			$quote->summary = Input::get('summary');
			$quote->save();
			return Redirect::to("/task/$task_id");
		} else {
			return Redirect::to("/task/$task_id")
				->withErrors($validator);
		}
	}


}