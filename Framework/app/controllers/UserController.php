<?php

class UserController extends BaseController {

		// public static $schoolList = [
		// 	'福州大学至诚学院',
		// ];

		// public static $majorCategoryList = [
		// 	'电气工程系',
		// 	'信息工程系',
		// 	'环境资源工程系',
		// 	'生物工程系',
		// 	'机械工程系',
		// 	'材料工程系',
		// 	'计算机工程系',
		// 	'化学工程系',
		// 	'土木工程系',
		// 	'建筑系',
		// 	'财经系',
		// 	'管理系',
		// 	'社会事务管理系',
		// 	'外国语系',
		// 	'音乐系',
		// 	'创意与设计系'
		// ];
		
		// public static $majorList = [
		// 	'电气工程及其自动化',
		// 	'自动化',
		// 	'电子信息工程',
		// 	'通信工程',
		// 	'电子科学与技术',
		// 	'微电子科学与工程',
		// 	'计算机科学与技术',
		// 	'软件工程',
		// 	'网络工程',
		// 	'机械设计制造及其自动化',
		// 	'过程装备与控制工程',
		// 	'工业设计',
		// 	'材料成型及控制工程',
		// 	'材料科学与工程',
		// 	'环境工程',
		// 	'安全工程',
		// 	'生物工程',
		// 	'食品科学与工程',
		// 	'材料化学',
		// 	'应用化学',
		// 	'化学工程与工艺',
		// 	'土木工程',
		// 	'建筑学',
		// 	'包装工程',
		// 	'生物技术',
		// 	'人文地理与城乡规划',
		// 	'工程管理',
		// 	'金融工程',
		// 	'国际经济与贸易',
		// 	'财务管理',
		// 	'行政管理',
		// 	'信息管理与信息系统',
		// 	'物流管理',
		// 	'英语',
		// 	'日语',
		// 	'商务英语',
		// 	'汉语言文学',
		// 	'音乐学',
		// 	'产品设计',
		// ];


	// public function unreadMessages() {
	// 	$unreadMessages = Message::where('read', false)->get();
	// 	return $unreadMessages;
	// }

	// public function messages() {
	// 	$messages = Message::all();
	// 	return $messages;
	// }

	
	// GET
	public function login() {

		return View::make('user.login');
	}
	
	public function register() {
		return View::make('user.register');
	}

	public function logout() {

		Auth::logout();
		// return Redirect::to('/');
		Session::flush();
		return Redirect::back();
	}

	public function profile($user_id) {

		$user = User::where('id', $user_id)->first();
		// $tasks = $user->task()->paginate(10);
		$commits = CommitPivot::where('user_id', $user_id)->get();
		$comments = Comment::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

		$schoolAge = Util::secToYear(strtotime(date('Y-m-d')) - strtotime($user->enrollment_date));
		$grade = Util::getGrade($user, $schoolAge);

		return View::make('user.profile')
			->with('user', $user)
			->with('grade', $grade)
			// ->with('tasks', $tasks);
			->with('commits', $commits)
			->with('comments', $comments);
	}


	// POST
	public function postLogin() {

		$remember = Input::get('remember', false);
		// $remember = false;
		// dd((boolean)'false');
		// dd(var_dump((bool)'false'));
		// PHP string 强转 bool 的原理：空字符串为false，否则为true
		if ($remember == 'false') {
			$remember = false;
		} elseif ($remember == 'true') {
			$remember = true;
		}
		// dd(var_dump($remember));

		$userInput = [
			// 'email'    => Input::get('email'),
			'tel'    => Input::get('phone'),
			'password' => Input::get('password'),
		];

		$rules = [
			// 'email'    => 'required|email',
			'tel'    => 'required|regex:/^[0-9]{11}$/',
			'password' => 'required|min:6'
		];

		$validator = Validator::make($userInput, $rules);

		if($validator->passes()) {

			if(Auth::attempt($userInput, $remember)) {
				// return Redirect::to('dashboard');
				if (Auth::user()->active == true) {
					return Redirect::intended('/');
				} else {
					Auth::logout();
					return View::make('user.login')
						// ->with('message', 'Your account has been locked, please email administrator for help: <a class="alert-link" href="/">admin@campuswitkey.com</a>');
						->with('message', Lang::get('user.your-account-has-been-locked, please-email-administrator-for-help', ['email'=>'admin@campuswitkey.com']));
				}
				// return Redirect::back();

			} else {
				return View::make('user.login')
					// ->with('message', 'email or password is incorrect!');
					->with('message', Lang::get('message.phone-or-password-is-incorrect!'));
			}

		} else {
			return Redirect::to('login')
				->withErrors($validator);
		}
	}

	public function postRegister() {

		// echo '<pre>';
		// die(var_dump(Input::all()));
		// echo '</pre>';
		$avatar_path = public_path() . '/avatar/';

		$userInput = [
			'phone'                 => Input::get('phone'),
			'password'              => Input::get('password'),
			'code' => Input::get('reg_code'),
			// 'password_confirmation' => Input::get('password_confirmation')
		];

		$rules = [
			'phone'    => 'required|regex:/^[0-9]{11}$/|unique:User,tel',
			'password' => 'required|min:6',
			'code' => 'regex:/^[0-9]{6}$/',
		];

		$validator = Validator::make($userInput, $rules);

		if($validator->passes()) {

			if ($userInput['code'] != Session::get($userInput['phone']) && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
				return View::make('user.register')
					->with('message', Lang::get('message.wrong-reg-code'));
				// die('wrong code');
			} else {
				// die('right');
			}

			if (is_writable($avatar_path)) {
				$user           = new User;
				$user->username = rand();
				$user->password = Hash::make($userInput['password']);
				$user->random_name  = true;
				$user->tel    = $userInput['phone'];
				$user->ip       = Request::ip();
				// $user->city     = Util::getCity();
				$user->save();

				$avatar = md5('avatar' . $user->id . $user->created_at);
				$user->avatar = $avatar;

				// $avatarFile = Response::download(public_path() . '/assets/image/default_avatar/1.jpg', 'name');
				copy(public_path() . '/assets/image/default_avatar/' . rand(1, 293) . '.jpg', $avatar_path . $avatar);


				$user->save();
				Auth::login($user);
				return Redirect::to('/');
			} else {
				return 'avatar path is not writable';
			}


		} else {
			
			return Redirect::to('register')->withErrors($validator);
		}

		return View::make('user.register');

	}

	public function message() {
		return View::make('message.index');
	}

	public function sendMessage() {
		$friends = Auth::user()->friend()->get();
		return View::make('message.send')
			->with('friends', $friends);
	}

	// handle with POST method
	public function postMessage() {
		// dd(var_dump(Input::all()));
		$userInput = [
			'to_user_id' => Input::get('friend_id'),
			'message' => Input::get('message')
		];
		// dd(var_dump($userInput));
		$rules = [
			'to_user_id' => 'required',
			'message' => 'required'
		];
		$validator = Validator::make($userInput, $rules);
		// dd(var_dump($validator->passes()));
		if ($validator->passes()) {
			$message = new Message;
			$message->from_user_id = Auth::user()->id;
			$message->to_user_id = $userInput['to_user_id'];
			$message->message = $userInput['message'];
			$message->read = false;
			$message->save();
			return Redirect::to('/message')
				->with('success', 'Message is sent successfully!');
		} else {
			return Redirect::to('/message/send')
				->withErrors($validator);
		}
	}

	public function detailMessage($message_id) {
		$message = Message::where('id', $message_id)->first();
		$message->read = true;
		$message->save();
		return View::make('message.detail')
			->with('message', $message);
	}

	public function allMessages() {
		return View::make('message.all');
	}

	public function sentMessage() {
		return View::make('message.sent');
	}

	public function readAllMessages() {
		$messages = Message::where('to_user_id', Auth::user()->id)->update(['read'=>true]);
		return Redirect::to('/message');
	}


	public function report($user_id) {
		$user = User::where('id', $user_id)->first();
		return View::make('user.report')
			->with('user', $user);
	}

	public function postReport($user_id) {
		$validator = Validator::make(['reason'=>Input::get('reason')], ['reason'=>'required']);
		if ($validator->passes()) {
			$reasonForReporting = new ReasonForReporting;
			$reasonForReporting->user_id = $user_id;
			$reasonForReporting->reason = Input::get('reason');
			$reasonForReporting->reporter_id = Auth::user()->id;
			$reasonForReporting->save();

			$user = User::where('id', $user_id)->first();
			$user->active = false;
			$user->save();
			return Redirect::to("/reportUser/$user_id");
		} else {
			return Redirect::back();
		}
	}

	// public function postAuthenticationFailed($user_id) {
	// 	$message = new Message;
	// 	$message->from_user_id = Auth::user()->id;
	// 	$message->to_user_id = $user_id;
	// 	$message->message = 'Authentication Failed!';
	// 	$message->read = false;
	// 	$message->save();
	// }

		// if (strlen(Auth::user()->fingerprint) && !Input::hasFile('idcard_image')) {
		// 	return View::make('user.dashboard.authentication')->with('error', 'No file selected!');
		// }






		// FILE INPUT
		// $fileInput = [
		// 	'idcard_image'=>Input::file('idcard_image')
		// ];
		// $fileRules = [
		// 	'idcard_image'=>'required|mimes:jpeg,jpg,gif,bmp|max:1024'
		// ];
		// $fileValidator = Validator::make($fileInput, $fileRules);

		// if (!Input::hasFile('idcard_image') && !strlen(Auth::user()->fingerprint)) {
		// 	// file not uploaded
		// } else if($fileValidator->fails()) {
		// 	// filetype error
		// } else {
		// 	// when the file does not exist in database, insert it
		// 	dd('upload');
		// 	$file = Input::file('idcard_image');
		// 	$fingerprint = md5(Auth::user()->id.Auth::user()->created_at);
		// 	$file->move(public_path().'/upload', $fingerprint);
		// 	User::where('id', Auth::user()->id)->update(['fingerprint'=>$fingerprint]);
		// }



// echo '<pre>';
// var_dump($fileValidator->messages());
// echo '</pre>';



		// return View::make('user.dashboard.authentication');
	// }
}