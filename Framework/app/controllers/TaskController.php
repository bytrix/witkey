<?php

class TaskController extends BaseController {

	public function manual() {
		return View::make('task.manual');
	}

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
		$task = Session::get('task');
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
			->with('hired_user', $hired_user)
			->with('task', $task);
	}

	// 2. SET A REWARD AMOUNT FOR YOUR DEMAND
	public function step_2() {
		if (Auth::user()->authenticated != 2) {
			return Redirect::action('TaskController@step_1');
		}
		if (isset($_POST['hire'])) {
			$hired_user = User::where('id', $_POST['hire'])->first();
		} else if (Session::has('hire')) {
			$hired_user = User::where('id', Session::get('hire'))->first();
		} else {
			$hired_user = NULL;
		}
		// dd(Input::all());
		$task = Session::get('task');
		// $userInput = [];
		if (Request::method() == "POST") {
			$userInput = [
				'title'  => Purifier::clean(Input::get('title'), 'titles'),
				// 'title' => Input::get('title'),
				'detail' => Input::get('detail'),
				'hire'   => Input::get('hire'),
				'file_name' => Input::get('file_name'),
				// 'expiration' => Input::get('expiration'),
				// 'category_id' => Input::get('category_id'),
				'amount' => '',
				'expiration' => '',
				'category_id' => '',
				'type' => 1,
				// 'hire' => $task['hire'],
				// 'file_name' => $task['file_name'],
				// 'expiration' => $task['expiration'],
				// 'category_id' => $task['category_id'],
			];
			// echo '<pre>';
			// dd(var_dump($task));
			// echo '</pre>';
		} else {
			// dd('dd');
			// $userInput = [
			// 	'title'  => e(Session::get('title')),
			// 	'detail' => Session::get('detail'),
			// 	'hire'   => Session::get('hire'),
			// 	'file_name' => Session::get('file_name'),
			// 	'category_id' => Session::get('category_id')
			// ];
			$userInput = [
				'title' => e($task['title']),
				'detail' => $task['detail'],
				'amount' => $task['amount'],
				'hire' => $task['hire'],
				'file_name' => $task['file_name'],
				'expiration' => $task['expiration'],
				'category_id' => $task['category_id'],
				'type' => $task['type'],
			];
		}
		// $userInput = [
		// 	'title' => e($task['title']),
		// 	'detail' => $task['detail'],
		// 	'hire' => $task['hire'],
		// 	'file_name' => $task['file_name'],
		// 	'expiration' => $task['expiration'],
		// 	'category_id' => $task['category_id'],
		// ];

		// dd(var_dump($userInput));

		$rules = [
			'title'  => 'required',
			'detail' => 'required',
			// 'category_id' => 'required|numeric'
		];
		$validator = Validator::make($userInput, $rules);

		if ($validator->passes()) {

			// Session::set('title' , $userInput['title']);
			// Session::set('detail', $userInput['detail']);
			// Session::set('type', $userInput['type']);
			// Session::set('hire', $userInput['hire']);
			// Session::set('file_name', $userInput['file_name']);
			// Session::set('category_id', $userInput['category_id']);

			// $task = array(
			// 	'title' => $userInput['title'],
			// 	'detail' => $userInput['detail'],
			// 	// 'type' => $userInput['type'],
			// 	'hire' => $userInput['hire'],
			// 	'file_name' => $userInput['file_name'],
			// 	'expiration' => $userInput['expiration'],
			// 	'category_id' => $userInput['category_id'],
			// 	);

			$task['title'] = $userInput['title'];
			$task['detail'] = $userInput['detail'];
			$task['amount'] = $userInput['amount'];
			$task['hire'] = $userInput['hire'];
			$task['file_name'] = $userInput['file_name'];
			$task['expiration'] = $userInput['expiration'];
			$task['category_id'] = $userInput['category_id'];
			$task['type'] = $userInput['type'];

			// dd('dd');

			Session::set('task', $task);

			// echo '<pre>';
			// dd(var_dump($task));
			// echo '</pre>';

			$categories = Category::all();
			return View::make('task.publish.step_2')
				->with('categories', $categories)
				->with('hired_user', $hired_user)
				->with('task', $task);

		} else {
			return Redirect::to('/task/create')->withErrors($validator);
		}
	}

	// 3. VALIDATE THE USER INPUT AND INSERT INTO DATABASE
	public function step_3() {
		// dd(Session::all());
		// echo '<pre>';
		// dd(var_dump(Input::all()));
		// dd(var_dump(Session::get('task')));
		// echo '</pre>';
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

		$task = Session::get('task', array());

		if (Request::method() == "POST") {
			$taskType = Input::get('type');
			// dd(Input::all());
			if (Input::has('academy_id') && !Cookie::has('school_id_session')) {
				$academy_id = Input::get('academy_id');
				// Session::set('school_id_session', $academy_id);
				Cookie::queue('school_id_session', $academy_id, 7*24*60);	// 7 days
				return Redirect::to('/task/create/step-3');
			}
			$userInput = [
				'type' => Input::get('type'),
				'expiration' => Input::get('expiration'),
				'category_id' => Input::get('category_id'),
			];
			if ($taskType == 1) {
				// $userInput = [
					// 'type'       => Input::get('type'),
					// 'amount'     => Input::get('amount'),
					// 'expiration' => Input::get('expiration'),
					// 'category_id'=> Input::get('category_id')
				// ];
				$userInput['amount'] = Input::get('amount');
				// $userInput['totalAmount'] = Input::get('totalAmount');
			} else if ($taskType == 2) {
				// $userInput = [
					// 'type'       => Input::get('type'),
					// 'amountStart'     => Input::get('amountStart'),
					// 'amountEnd'     => Input::get('amountEnd'),
					// 'expiration' => Input::get('expiration'),
					// 'category_id'=> Input::get('category_id')
				// ];
				$userInput['amountStart'] = Input::get('amountStart');
				$userInput['amountEnd'] = Input::get('amountEnd');
				if ($userInput['amountStart'] > $userInput['amountEnd']) {
					$temp = $userInput['amountStart'];
					$userInput['amountStart'] = $userInput['amountEnd'];
					$userInput['amountEnd'] = $temp;
				}
				if ($userInput['amountStart'] == $userInput['amountEnd']) {
					$userInput['amount'] = $userInput['amountStart'];
					unset($task['amountStart']);
					unset($task['amountEnd']);
				}
			}
			// Session::set('type', Input::get('type'));
		} else {
			$taskType = $task['type'];
			// echo '<pre>';
			// dd(var_dump(Session::all()));
			// echo '</pre>';
			// if (Session::get('type') == 1) {
			// 	$userInput = [
			// 		'type'       => Session::get('type'),
			// 		'amount'     => Session::get('amount'),
			// 		'expiration' => Session::get('expiration'),
			// 		'category_id'=> Session::get('category_id')
			// 	];
			// } else if (Session::get('type') == 2) {
			// 	$userInput = [
			// 		'type'       => Session::get('type'),
			// 		'amountStart'     => Session::get('amountStart'),
			// 		'amountEnd'     => Session::get('amountEnd'),
			// 		'expiration' => Session::get('expiration'),
			// 		'category_id'=> Session::get('category_id')
			// 	];
			// }
			$userInput = [
				'type' => $task['type'],
				'expiration' => $task['expiration'],
				'category_id' => $task['category_id'],
			];
			if ($taskType == 1 || !isset($task['amountStart'])) {
				$userInput['amount'] = $task['amount'];
			} elseif ($taskType == 2 && isset($task['amountStart'])) {
				$userInput['amountStart'] = $task['amountStart'];
				$userInput['amountEnd'] = $task['amountEnd'];
			}
		}




		// if (Input::get('type') == 1 || Session::get('type') == 1) {
		// 	$userInput = [
		// 		'type'       => Input::get('type'),
		// 		'amount'     => Input::get('amount'),
		// 		'expiration' => Input::get('expiration'),
		// 		'category_id'=> Input::get('category_id')
		// 	];
		// } else if (Input::get('type') == 2 || Session::get('type') == 2) {
		// 	$userInput = [
		// 		'type'       => Input::get('type'),
		// 		'amountStart'     => Input::get('amountStart'),
		// 		'amountEnd'     => Input::get('amountEnd'),
		// 		'expiration' => Input::get('expiration'),
		// 		'category_id'=> Input::get('category_id')
		// 	];
		// }
		// if (Request::method() == "POST") {
		// 	Session::set('type', Input::get('type'));
		// }



		// if (Input::get('type') == 1 || Session::get('type') == 1) {
		// 	$rules = [
		// 		'type'       => 'required',
		// 		'amount'     => 'required|numeric|between:0.1,5000',
		// 		'expiration' => 'required|date|future',
		// 		'category_id'=> 'required'
		// 	];
		// } else  if (Input::get('type') == 2 || Session::get('type') == 2) {
		// 	$rules = [
		// 		'type'       => 'required',
		// 		'amountStart'     => 'required|numeric|between:0.1,5000',
		// 		'amountEnd'     => 'required|numeric|between:0.1,5000',
		// 		'expiration' => 'required|date|future',
		// 		'category_id'=> 'required'
		// 	];
		// }

		// $taskType = Input::get('type');
		if ($taskType == 1) {
			$rules = [
				'type'       => 'required',
				'amount'     => 'required|numeric|between:0.1,5000',
				'expiration' => 'required|date|future',
				'category_id'=> 'required'
			];
		} else  if ($taskType == 2) {
			$rules = [
				'type'       => 'required',
				'amountStart'     => 'numeric|between:0.1,5000',
				'amountEnd'     => 'numeric|between:0.1,5000',
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
		$task = Session::get('task');
		// dd('dd');
		if (isset($userInput) && isset($rules)) {
			$validator = Validator::make($userInput, $rules);
			// dd($userInput);
			// dd($validator->passes());
			if ($validator->passes()) {
				// Session::set('type'      , $userInput['type']);
				$task['type'] = $userInput['type'];

				if ($task['type'] == 1 || !isset($userInput['amountStart'])) {
					// Session::set('amount'    , $userInput['amount']);
					$task['amount'] = $userInput['amount'];
					// $task['totalAmount'] = $userInput['amount'] * (1 + 0.04);
					$task['totalAmount'] = Util::getTotalFee($userInput['amount']);
				} else if ($task['type'] == 2) {
					// Session::set('amountStart'    , $userInput['amountStart']);
					// Session::set('amountEnd'    , $userInput['amountEnd']);
					$task['amountStart'] = $userInput['amountStart'];
					$task['amountEnd'] = $userInput['amountEnd'];
					if ($userInput['amountStart'] == $userInput['amountEnd']) {
						$task['amount'] = $userInput['amountStart'];
						unset($task['amountStart']);
						unset($task['amountEnd']);
					}
				}

				// Session::set('expiration', $userInput['expiration']);
				// Session::set('category_id', $userInput['category_id']);
				$task['expiration'] = $userInput['expiration'];
				$task['category_id'] = $userInput['category_id'];
				$task['trade_no'] = date('ymdHis') . '0' . $task['type'] . rand(1000, 9999);	// 0 stands for task
				Session::set('task', $task);

				// echo '<pre>';
				// dd(var_dump(Session::get('task')));
				// echo '</pre>';

				return View::make('task.publish.step_3')
					->with('task', $task);
			} else {
				// return Redirect::back()->withErrors($validator);
				return Redirect::to('/task/create/step-2')
					->withErrors($validator);
			}
		} else {
			return Redirect::to('/task/create/step-2');
		}


	}

	public function uploadImage() {
		$data = [
			'success' => false,
			'msg' => 'wrong',
			'file_path' => ''
		];
		$file = Input::file('fileData');
		// $user = new User;
		// $user->username = $file->getRealPath();
		// $user->save();
		// $filePath = public_path() . '/upload/cache/' . Auth::user()->id;
		if ($file) {
			$filePath = public_path() . '/file/' . Auth::user()->id;
			$fileName = 'IMG_' . date('YmdHis');
			$file->move($filePath, $fileName);
			$data['success'] = true;
			$data['msg'] = 'ok';
			$data['file_path'] = '/file/' . Auth::user()->id . '/' . $fileName;
		}
		return $data;

		// $attachment = new Attachment;
		// $attachment->user_id = Auth::user()->id;
		// $attachment->file_name = $fileName;
		// $attachment->save();

		// $image = new Image;
		// $image->user_id = Auth::user()->id;
		// $image->file_name = $fileName;
		// $image->save();
		// Session::push('images', $fileName);
	}

	public function listTask($academy_id) {
		// Session::set('school_id_session', $academy_id);
		Cookie::queue('school_id_session', $academy_id, 7*24*60);	// 7 days

		$myAcademy = Academy::where('id', $academy_id)->first();
		$academies = Academy::all();
		$categories = Category::all();


		switch (Input::get('sort')) {
			case 'more-reward':
				$tasks = Task::where('place', $academy_id)
					->where('state', '!=', 0)
					->orderBy('amount', 'desc')
					->paginate(10);
				break;
			
			case 'less-expiration':
				$tasks = Task::where('place', $academy_id)
					->where('state', '!=', 0)
					->orderBy('expiration', 'asc')
					->paginate(10);
				break;

			case 'less-participator':
				$tasks = Task::where('place', $academy_id)
					->where('state', '!=', 0)
					->where('state', '!=', 4)
					->where('state', '!=', 5)
					->orderBy('participator_count', 'asc')
					->paginate(10);
				break;

			default:
				$tasks = Task::where('place', $academy_id)
					->where('state', '!=', 0)
					->orderBy('created_at', 'desc')
					->paginate(10);
				break;
		}

		return View::make('task.list')
			->with('tasks', $tasks)
			->with('mySchool', $myAcademy)
			->with('schools', $academies)
			->with('category_id', 0)
			->with('categories', $categories);
	}


	public function subCategory($academy_id, $category_id) {
		// Session::set('school_id_session', $academy_id);
		Cookie::queue('school_id_session', $academy_id, 7*24*60);	// 7 days
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
				// $commits = 's';

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

	public function historyCommit($task_id, $user_id) {
		$commit = CommitPivot::where(array('user_id'=>$user_id, 'task_id'=>$task_id))->orderBy('created_at', 'desc')->first();
		$historyCommit = CommitPivot::where('task_id', $task_id)->orderBy('created_at', 'desc')->get();
		unset($historyCommit[0]);
		return View::make('task.historyCommit')
			->with('task_id', $task_id)
			->with('commit', $commit)
			->with('historyCommit', $historyCommit);
	}

	// public function modifyPrice($task_id) {
	// 	$task = Task::where('id', $task_id)->first();
	// 	$task->amount = Input::get('price');
	// 	$task->save();
	// 	return Redirect::to("/task/$task_id");
	// }

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
		$task = Task::where('id', $task_id)->get();
		$validator = Validator::make(['reason'=>Input::get('reason')], ['reason'=>'required']);
		if ($validator->passes()) {
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
			$task_title = "<b style='color: #777;'>$task->title</b>";
			$template = '您的任务 ' . $task_title . ' 由于以下原因被关闭：<br />----------------------------------------------------<br />';
			$message->message = $template . Input::get('reason');
			$message->save();
			return Redirect::to("/task/$task_id");
		} else {
			return Redirect::back();
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
		// $academy_id = Session::get('school_id_session');
		$academy_id = Cookie::get('school_id_session');
		if ($academy_id == NULL) {
			return Redirect::to('/task/create/step-3')
				->with('message', 'no-school');
		}
		$sTask = Session::get('task');
		$task             = new Task;
		$task->user_id    = Auth::user()->id;
		// $task->type       = Session::get('type');
		// $task->title      = Session::get('title');
		// $task->detail     = Session::get('detail');
		// $task->category_id   = Session::get('category_id');
		$task->type = $sTask['type'];
		$task->title = $sTask['title'];
		$task->detail = $sTask['detail'];
		$task->category_id = $sTask['category_id'];

		if ($sTask['type'] == 1) {
			// $task->amount     = Session::get('amount');
			$task->amount = $sTask['amount'];
			$task->totalAmount = $sTask['totalAmount'];
		} else if ($sTask['type'] == 2) {
			// $task->amountStart     = Session::get('amountStart');
			// $task->amountEnd     = Session::get('amountEnd');
			if (isset($sTask['amountStart'])) {
				$task->amountStart = $sTask['amountStart'];
				$task->amountEnd = $sTask['amountEnd'];
			} else {
				$task->amount = $sTask['amount'];
			}
		}

		// $task->amount     = Session::get('amount');
		// $task->expiration = Session::get('expiration');
		$task->expiration = $sTask['expiration'];
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
				copy(public_path() . '/upload/cache/' . $attachment->file_name, public_path() . '/file/' . Auth::user()->id . '/' . $attachment->file_hash);
			} else {
				copy(public_path() . '/upload/cache/' . $attachment->file_name, public_path() . '/file/' . Auth::user()->id . '/' . $attachment->file_hash . '.' . $attachment->file_ext);
			}
		}

		// if (Session::has('images')) {
		// 	if (!file_exists(public_path() . '/file/' . Auth::user()->id . '/')) {
		// 		mkdir(public_path() . '/file/' . Auth::user()->id . '/');
		// 	}
		// 	$images = Session::get('images');
		// 	foreach ($images as $imageName) {
		// 		$oldName = public_path() . '/upload/cache/' . Auth::user()->id . '/' . $imageName;
		// 		$newName = public_path() . '/file/' . Auth::user()->id . '/' .$imageName;
		// 		rename($oldName, $newName);

		// 		$image = new Image;
		// 		$image->user_id = Auth::user()->id;
		// 		$image->task_id = $task->id;
		// 		$image->file_name = $imageName;
		// 		$image->save();
		// 	}
		// }

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
		if ($validator->passes() && Auth::user()->alipay_account != "") {
			$commit = new CommitPivot;
			$commit->task_id = $task_id;
			$commit->user_id = Auth::user()->id;
			$commit->summary = Input::get('summary');
			$commit->type = Input::get('type');
			$commit->quote_id = Input::get('quote_id');
			$commit->save();
			$task = Task::where('id', $task_id)->first();
			CommitPivot::where('id', '=', $commit->id)
				->update([
						// 'uuid' => md5($commit->id . $commit->created_at . $commit->task_id . $commit->user_id . $commit->summary . $commit->type . $commit->quote_id . $commit->file_hash)
						'uuid' => date('ymdHis') . '1' . $task->type . rand(1000, 9999)	// 1 stands for commit
					]);
			if ($task->type == 1) {
				$task->state = 2;
				$task->participator_count = count($task->bidder);
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
			$task = Task::where('id', $task_id)->first();
			$task->participator_count = count($task->bidder);
			$task->save();
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
		// $commit->win = true;
		// $commit->save();
		$task = Task::where('id', $task_id)->first();
		// if ($task->type == 1) {
		// 	$task->winning_commit_id = $commit->id;
		// 	$task->save();
		// }
		if ($task->winning_commit_id != 6) {
			return View::make('task.pay')
				->with('task', $task)
				->with('commit', $commit);
		} else {
			App::abort('404', 'Trade Over');
		}
	}

	public function postPay($commit_uuid) {


		$username = Auth::user()->username;
		$password = Input::get('password');
		
		$userPassword = Auth::user()->password;

		if (! Auth::validate(array('username'=>$username, 'password'=>$password))) {
			return Redirect::back()
				->with('message', 'wrong-credential');
		} else {
			$commit = CommitPivot::where('uuid', $commit_uuid)->first();
			// dd(var_dump($commit->task->id));
			$commit->win = true;
			$commit->save();
			$task = $commit->task;
			if ($task->type == 1) {
				$task->winning_commit_id = $commit->id;
				$task->state = 4;
				$task->save();
			}
			return Redirect::to("/task/" . $task->id);
		}
	}

	public function successPay($commit_uuid) {
		$task_id = Session::get('task_id_session');
		$commit_uuid = Session::get('commit_uuid_session');
		$commit = CommitPivot::where('uuid', $commit_uuid)->first();
		$task = Task::where('id', $task_id)->first();
		// $task->state = 4;
		// $task->save();
		return View::make('task.successPay')
			->with('task', $task)
			->with('commit', $commit);
	}

	public function orderSuccess($trade_no) {
		// return $trade_no;
		$task = Task::where('trade_no', $trade_no)->first();
		return View::make('task.orderSuccess')
			->with('trade_no', $trade_no)
			->with('task', $task);
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
