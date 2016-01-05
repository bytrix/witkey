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
				'title'  => Purifier::clean(Input::get('title'), 'titles'),
				'detail' => Input::get('detail')
			];
		} else {
			$userInput = [
				'title'  => e(Session::get('title')),
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
		},"The amount field cannot be negative");
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
		Session::set('task_id_session', $task->id);
		if ($task->user->active == 0) {
			return View::make('task.closed');
		}
		if ($task->type == 1) {
			$commit_sum = count(CommitPivot::where(['task_id'=>$task_id])->get());
		} else if($task->type == 2) {
			$quote_sum = count(QuotePivot::where(['task_id'=>$task_id])->get());
			$quote_price_sum = 0;
			$quote_price_avg = 0;
			$bidder_count = 0;
			foreach ($task->bidder as $bidder) {
				$bidder_count++;
				$quote_price_sum += $bidder->findLatestQuoteById($bidder->id, $task->id)->first()->price;
			}
			if ($bidder_count != 0) {
				$quote_price_avg = $quote_price_sum / $bidder_count;
			} else {
				$quote_price_avg = 0;
			}
		}
		if (Auth::check()) {
			if ($task->type == 1) {
				// dd(var_dump($task->user_id == Auth::user()->id));
				if ($task->user_id == Auth::user()->id) {
					$all_commits = CommitPivot::where(['task_id'=>$task_id]);
				} else {
					// dd(var_dump(Auth::user()->isBidder($task_id)));
					if (Auth::user()->isBidder($task_id)) {
						$all_commits = CommitPivot::where(['task_id'=>$task_id, 'user_id'=>Auth::user()->id]);
					} else {
						// dd('a'); 
						return View::make('task.detail')
							->with('task_id', $task_id)
							->with('task', $task)
							->with('commit_sum', $commit_sum);
					}
				}
				$commits = $all_commits->orderBy('created_at', 'desc')->paginate(5);
				return View::make('task.detail')
					->with('task_id', $task_id)
					->with('task', $task)
					->with('commits', $commits)
					->with('commit_sum', $commit_sum);

			} else if($task->type == 2) {
				if ($task->user_id == Auth::user()->id) {
					$all_quotes = QuotePivot::where(['task_id'=>$task_id]);
					// $all_quotes = $task->quotes;
				} else {
					if (Auth::user()->isBidder($task_id)) {
						$all_quotes = QuotePivot::where(['task_id'=>$task_id, 'user_id'=>Auth::user()->id]);
					} else {
						return View::make('task.detail')
							->with('task_id', $task_id)
							->with('task', $task)
							->with('quote_sum', $quote_sum)
							->with('quote_price_avg', $quote_price_avg);
					}
				}
				$quotes = $all_quotes->orderBy('created_at', 'desc')->paginate(5);
				return View::make('task.detail')
					->with('task_id', $task_id)
					->with('task', $task)
					->with('quotes', $quotes)
					->with('quote_sum', $quote_sum)
					->with('quote_price_avg', $quote_price_avg);
			}
		}


		if ($task->type == 1) {
			return View::make('task.detail')
				->with('task_id', $task_id)
				->with('task', $task)
				->with('commit_sum', $commit_sum);
		} else if ($task->type == 2) {
			return View::make('task.detail')
				->with('task_id', $task_id)
				->with('task', $task)
				->with('quote_sum', $quote_sum)
				->with('quote_price_avg', $quote_price_avg);
		}
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
		$task->state      = 1;
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
			$commit->type = Input::get('type');
			$commit->quote_id = Input::get('quote_id');
			$commit->save();
			CommitPivot::where('task_id', '=', $task_id)
				->update([
						'uuid' => md5($commit->id . $commit->created_at . $commit->task_id . $commit->user_id . $commit->summary . $commit->type . $commit->quote_id . $commit->file_hash)
					]);
			$task = Task::where('id', $task_id)->first();
			if ($task->type == 1) {
				$task->state = 2;
			} else if ($task->type == 2) {
				$task->state = 3;
			}
			$task->save();
			return Redirect::to("/task/$task_id");
		} else {
			return Redirect::to("/task/$task_id")
				->withErrors($validator);
		}
	}

	public function postQuote($task_id) {
		$userInput = [
			'summary' => Input::get('summary'),
			'price' => Input::get('price'),
		];
		$rules = [
			'summary' => 'required',
			'price' => 'required',
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			$quote = new QuotePivot;
			$quote->task_id = $task_id;
			$quote->user_id = Auth::user()->id;
			$quote->summary = $userInput['summary'];
			$quote->price = $userInput['price'];
			$quote->save();
			return Redirect::to("/task/$task_id");
		} else {
			return Redirect::to("/task/$task_id")
				->withErrors($validator);
		}
	}

	public function commitHosting($task_id, $bid_id) {
		$task = Task::where('id', $task_id)->first();
		if ($task->type == 1) {
			$commit = CommitPivot::where('id', $bid_id)->first();
			return View::make('task.commitHosting')
				->with('task', $task)
				->with('commit', $commit);
		}
	}

	public function quoteHosting($task_id, $bid_id) {
		$task = Task::where('id', $task_id)->first();
		if ($task->type == 2) {
			$quote = QuotePivot::where('id', $bid_id)->first();
			return View::make('task.quoteHosting')
				->with('task', $task)
				->with('quote', $quote);
		}
	}


	public function winBid($task_id, $bid_id) {
		$task = Task::where('id', $task_id)->first();
		// $quote = QuotePivot::where('id', $quote_id)->first();
		if ($task->type == 1) {
			$commit = CommitPivot::where('id', $bid_id)->first();
			$task->winning_commit_id = $commit->uuid;
		} else if ($task->type == 2) {
			$quote = QuotePivot::where('id', $bid_id)->first();
			$task->winning_quote_id = $quote->id;
		}
		// $task->winning_bidder_id = $quote->user->id;
		if ($task->type == 1) {
			$task->state = 3;
		} else if($task->type == 2) {
			$task->state = 2;
		}
		$task->save();
		return Redirect::to('task/'.$task_id);
	}


	public function pay($commit_uuid) {
		$task_id = Session::get('task_id_session');
		Session::set('commit_uuid_session', $commit_uuid);
		$commit = CommitPivot::where('uuid', $commit_uuid)->first();
		// dd($task_id);
		$task = Task::where('id', $task_id)->first();
		if ($task->type == 1) {
			$task->winning_commit_id = $commit->id;
			$task->save();
		}
		return View::make('task.pay')
			->with('task', $task)
			->with('commit', $commit);
	}

	public function successPay($commit_uuid) {
		$task_id = Session::get('task_id_session');
		$commit_uuid = Session::get('commit_uuid_session');
		$commit = CommitPivot::where('uuid', $commit_uuid)->first();
		$task = Task::where('id', $task_id)->first();
		$task->state = 4;
		$task->save();
		return View::make('task.successPay')
			->with('task', $task)
			->with('commit', $commit);
		// Session::forget('task_id_session');
		// return Redirect::to("/pay/$commit_uuid")
		// 	->with('payStatus', 'ok');
		// return 'success';
	}

}
