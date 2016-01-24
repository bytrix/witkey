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
		$friends = Auth::user()->friend()->get();
		if (isset($_GET['hire']) && $_GET['hire'] != Auth::user()->id && $_GET['hire'] != 1) {
			$hired_user = User::where('id', $_GET['hire'])->first();
			if ($hired_user->authenticated != 2) {
				$hired_user = NULL;
			}
		} else {
			$hired_user = NULL;
			Session::forget('hire');
		}
		return View::make('task.publish.step_1')
			->with('friends', $friends)
			->with('hired_user', $hired_user);
	}

	// 2. SET A REWARD AMOUNT FOR YOUR DEMAND
	public function step_2() {
		if (isset($_POST['hire'])) {
			$hired_user = User::where('id', $_POST['hire'])->first();
		} else if (Session::has('hire')) {
			$hired_user = User::where('id', Session::get('hire'))->first();
		} else {
			$hired_user = NULL;
		}
		// dd(Input::all());
		if (Request::method() == "POST") {
			$userInput = [
				'title'  => Purifier::clean(Input::get('title'), 'titles'),
				'detail' => Input::get('detail'),
				'hire'   => Input::get('hire'),
				'file_name' => Input::get('file_name')
				// 'category_id' => Input::get('category_id')
			];
		} else {
			$userInput = [
				'title'  => e(Session::get('title')),
				'detail' => Session::get('detail'),
				'hire'   => Session::get('hire'),
				'file_name' => Session::get('file_name')
				// 'category_id' => Session::get('category_id')
			];
		}

		$rules = [
			'title'  => 'required',
			'detail' => 'required',
			// 'category_id' => 'required|numeric'
		];
		$validator = Validator::make($userInput, $rules);

		if ($validator->passes()) {
			Session::set('title' , $userInput['title']);
			Session::set('detail', $userInput['detail']);
			Session::set('hire', $userInput['hire']);
			Session::set('file_name', $userInput['file_name']);
			// Session::set('category_id', $userInput['category_id']);
			$categories = Category::all();
			return View::make('task.publish.step_2')
				->with('categories', $categories)
				->with('hired_user', $hired_user);

		} else {
			return Redirect::to('/task/create')->withErrors($validator);
		}
	}

	// 3. VALIDATE THE USER INPUT AND INSERT INTO DATABASE
	public function step_3() {
		// dd(var_dump(Input::all()));
		// Validator::extend('positive', function($attribute, $value, $parameters) {
		// 	if ($value < 0) {
		// 		return false;
		// 	} else {
		// 		return true;
		// 	}
		// },"The amount field cannot be negative");
		Validator::extend('future', function($attribute, $value, $parameters) {
			$expiration = strtotime($value);
			$now = strtotime("now");
			if ($expiration > $now) {
				return true;
			} else {
				return false;
			}
		}, "Expiration is out of date!");



		if (Request::method() == "POST") {
			if (Input::get('type') == 1) {
				$userInput = [
					'type'       => Input::get('type'),
					'amount'     => Input::get('amount'),
					'expiration' => Input::get('expiration'),
					'category_id'=> Input::get('category_id')
				];
			} else if (Input::get('type') == 2) {
				$userInput = [
					'type'       => Input::get('type'),
					'amountStart'     => Input::get('amountStart'),
					'amountEnd'     => Input::get('amountEnd'),
					'expiration' => Input::get('expiration'),
					'category_id'=> Input::get('category_id')
				];
			}
		} else {
			if (Input::get('type') == 1) {
				$userInput = [
					'type'       => Session::get('type'),
					'amount'     => Session::get('amount'),
					'expiration' => Session::get('expiration'),
					'category_id'=> Input::get('category_id')
				];
			} else if (Input::get('type') == 2) {
				$userInput = [
					'type'       => Session::get('type'),
					'amountStart'     => Session::get('amountStart'),
					'amountEnd'     => Session::get('amountEnd'),
					'expiration' => Session::get('expiration'),
					'category_id'=> Input::get('category_id')
				];
			}
		}



		if ($userInput['type'] == 1) {
			$rules = [
				'type'       => 'required',
				'amount'     => 'required|numeric|between:0.1,5000',
				'expiration' => 'required|date|future',
				'category_id'=> 'required'
			];
		} else  if ($userInput['type'] == 2) {
			$rules = [
				'type'       => 'required',
				'amountStart'     => 'required|numeric|between:0.1,5000',
				'amountEnd'     => 'required|numeric|between:0.1,5000',
				'expiration' => 'required|date|future',
				'category_id'=> 'required'
			];
		}


		// $rules = [
		// 	'type'       => 'required',
		// 	'amount'     => 'required|numeric|between:0.1,5000',
		// 	'expiration' => 'required|date|future',
		// 	'category_id'=> 'required'
		// ];
		$validator = Validator::make($userInput, $rules);
		// dd($userInput);
		if ($validator->passes()) {
			Session::set('type'      , $userInput['type']);

			if (Session::get('type') == 1) {
				Session::set('amount'    , $userInput['amount']);
			} else if (Session::get('type') == 2) {
				Session::set('amountStart'    , $userInput['amountStart']);
				Session::set('amountEnd'    , $userInput['amountEnd']);
			}

			Session::set('expiration', $userInput['expiration']);
			Session::set('category_id', $userInput['category_id']);

			return View::make('task.publish.step_3');
		} else {
			return Redirect::back()->withErrors($validator);
		}
	}

	public function listTask($academy_id) {
		Session::set('school_id_session', $academy_id);
		$myAcademy = Academy::where('id', $academy_id)->first();
		$academies = Academy::all();
		$categories = Category::all();

		$tasks = Task::where('place', $academy_id)
			->where('state', '!=', 0)
			->orderBy('created_at', 'desc')
			->paginate(10);

		return View::make('task.list')
			->with('tasks', $tasks)
			->with('mySchool', $myAcademy)
			->with('schools', $academies)
			->with('category_id', 0)
			->with('categories', $categories);
	}


	public function subCategory($academy_id, $category_id) {
		Session::set('school_id_session', $academy_id);
		$myAcademy = Academy::where('id', $academy_id)->first();
		$academies = Academy::all();
		$categories = Category::all();

		$tasks = Task::where(['place'=>$academy_id, 'category_id'=>$category_id])
			->orderBy('created_at', 'desc')
			->paginate(10);

		return View::make('task.list')
			->with('tasks', $tasks)
			->with('mySchool', $myAcademy)
			->with('schools', $academies)
			->with('category_id', $category_id)
			->with('categories', $categories);
	}

	public function search($academy_id, $keyword) {
		$categories = Category::all();
		$tasks = Task::where('title', 'like', '%' . $keyword . '%')->paginate(10);
		// dd($tasks);
		return View::make('task.list')
			->with('tasks', $tasks)
			->with('category_id', 0)
			->with('categories', $categories)
			->with('keyword', $keyword);
	}

	public function detail($task_id) {

		$task = Task::where('id', $task_id)->first();
		// dd($task->attachment);
		if ($task->user->active == false || $task->state == 0) {

			return View::make('task.closed');
		}
		$prev_task = Task::where('id', $task_id + 1)->first();
		$next_task = Task::where('id', $task_id - 1)->first();
		$school = Academy::where('id', $task->place)->first();
		View::share('task_id', $task_id);
		View::share('task', $task);
		View::share('prev_task', $prev_task);
		View::share('next_task', $next_task);
		View::share('school', $school);
		View::share('attachment', $task->attachment);
		View::share('categories', Category::all());
		Session::set('task_id_session', $task_id);

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

		if (Auth::guest()) {
			if ($task->type == 1) {
				return View::make('task.detail')
					->with('commit_sum', $commit_sum);

			} else if ($task->type == 2) {
				return View::make('task.detail')
					->with('quote_sum', $quote_sum)
					->with('quote_price_avg', $quote_price_avg);
			}
		}

		if (Auth::check()) {
			if ($task->type == 1) {

				if ($task->user_id == Auth::user()->id) {
					$all_commits = CommitPivot::where(['task_id'=>$task_id]);

				} else {

					if (Auth::user()->isBidder($task_id)) {
						$all_commits = CommitPivot::where(['task_id'=>$task_id, 'user_id'=>Auth::user()->id]);
					} else {
						return View::make('task.detail')
							->with('commit_sum', $commit_sum);
					}
				}

				$commits = $all_commits->orderBy('created_at', 'desc')->paginate(5);

				return View::make('task.detail')
					->with('commits', $commits)
					->with('commit_sum', $commit_sum);

			} else if($task->type == 2) {

				if ($task->user_id == Auth::user()->id) {
					$all_quotes = QuotePivot::where(['task_id'=>$task_id]);

				} else {

					if (Auth::user()->isBidder($task_id)) {
						$all_quotes = QuotePivot::where(['task_id'=>$task_id, 'user_id'=>Auth::user()->id]);
					} else {
						return View::make('task.detail')
							->with('quote_sum', $quote_sum)
							->with('quote_price_avg', $quote_price_avg);
					}
				}

				$quotes = $all_quotes->orderBy('created_at', 'desc')->paginate(5);

				return View::make('task.detail')
					->with('quotes', $quotes)
					->with('quote_sum', $quote_sum)
					->with('quote_price_avg', $quote_price_avg);
			}
		}
	}

	public function changeCategory($task_id) {
		// dd(Input::all());
		$task = Task::where('id', $task_id)->first();
		$task->category_id = Input::get('category_id');
		$task->save();
		$message = new Message;
		$message->from_user_id = Auth::user()->id;
		$message->to_user_id = $task->user->id;
		$message->message = "Your task has been transferred to category " . $task->category['name'] . " by campus witkey manager";
		$message->save();
		return Redirect::to("/task/$task_id");
	}

	public function deleteTask($task_id) {
		// dd(Input::all());
		$task = Task::where('id', $task_id)->first();
		$task->state = 0;
		$task->save();
		$reasonForDeleting = new ReasonForDeleting;
		$reasonForDeleting->task_id = $task_id;
		$reasonForDeleting->reason = Input::get('reason');
		$reasonForDeleting->save();
		$message = new Message;
		$message->from_user_id = Auth::user()->id;
		$message->to_user_id = $task->user->id;
		$message->message = "Your task has been closed by campus witkey manager with following reason:<br>----------------------------------------<br>" . Input::get('reason');
		$message->save();
		return Redirect::to("/task/$task_id");
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
		$academy_id = Session::get('school_id_session');
		$task             = new Task;
		$task->user_id    = Auth::user()->id;
		$task->type       = Session::get('type');
		$task->title      = Session::get('title');
		$task->detail     = Session::get('detail');
		$task->category_id   = Session::get('category_id');

		if (Session::get('type') == 1) {
			$task->amount     = Session::get('amount');
		} else if (Session::get('type') == 2) {
			$task->amountStart     = Session::get('amountStart');
			$task->amountEnd     = Session::get('amountEnd');
		}

		$task->amount     = Session::get('amount');
		$task->expiration = Session::get('expiration');
		$task->state      = 1;
		$task->place = $academy_id;
		$task->save();
		$credit = Auth::user()->credit;

		// dd($task->category_id);

		User::where('id', Auth::user()->id)
			->update(['credit' => ($credit - 50)]);

		if (Session::get('hire') != NULL) {
			$hired_user = User::where('id', Session::get('hire'))->first();
			$message = new Message;
			$message->from_user_id = Auth::user()->id;
			$message->to_user_id = $hired_user->id;
			$message->message = "Can you help me do this task " . "<a class='message-task-title' target='blank' href=\"/task/$task->id\">$task->title</a> ?";
			$message->save();
		}

		if (Session::has('file_name') && Session::get('file_name') != "") {
			// dd(Session::get('file_name'));
			$attachment = new Attachment;
			$attachment->file_name = Session::get('file_name');
			$attachment->task_id = $task->id;
			$attachment->save();
			$attachment->file_hash = md5($attachment->id . $attachment->created_at . $attachment->file_name . $attachment->task_id);
			$attachment->file_ext = Util::getExtension($attachment->file_name);
			$attachment->save();
			// Session::set('file_hash', $attachment->file_hash);
			if (!file_exists(public_path() . '/file/' . Auth::user()->id . '/')) {
				mkdir(public_path() . '/file/' . Auth::user()->id . '/');
			}
			if ($attachment->file_ext == "") {
				copy(public_path() . '/upload/cache/' . $attachment->file_name, public_path() . '/file/' . Auth::user()->id . '/' . $attachment->file_hash . '.s');
			} else {
				copy(public_path() . '/upload/cache/' . $attachment->file_name, public_path() . '/file/' . Auth::user()->id . '/' . $attachment->file_hash . '.' . $attachment->file_ext);
			}
		}

		Session::forget('title');
		Session::forget('detail');
		Session::forget('amount');
		Session::forget('expiration');
		Session::forget('hire');
		Session::forget('file_name');

		// return Redirect::to('task/list');
		return Redirect::to("/school/$academy_id");
		// return Redirect::to('/');
	}


	public function postCommit($task_id) {
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
			CommitPivot::where('id', '=', $commit->id)
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
		if ($task->type == 1) {
			$commit = CommitPivot::where('id', $bid_id)->first();
			$task->winning_commit_id = $commit->uuid;
		} else if ($task->type == 2) {
			$quote = QuotePivot::where('id', $bid_id)->first();
			$task->winning_quote_id = $quote->id;
		}
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
		$commit->win = true;
		$commit->save();
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
	}


	public function postDelay($task_id) {
		$userInput = [
			'expiration' => Input::get('expiration')
		];
		$rules = [
			'expiration' => 'required'
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			$task = Task::where('id', $task_id)->first();
			$task->expiration = $userInput['expiration'];
			$task->state = 1;
			$task->save();
		}
		return Redirect::back();
	}


}
