<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
		View::share('mySchool', $this->mySchool());
		View::share('schools', $this->allSchools());
		if (Auth::check() && Auth::user()->active == true) {
			View::share('unreadMessages', $this->unreadMessages());
			View::share('messages', $this->messages());
			View::share('sentMessages', $this->sentMessages());
		}
	}

	public function mySchool() {
		// $academy_id = Session::get('school_id_session');
		$academy_id = Cookie::get('school_id_session');
		$mySchool = Academy::where('id', $academy_id)->first();
		return $mySchool;
	}

	public function allSchools() {
		$academies = Academy::all();
		return $academies;
	}

	public function unreadMessages() {
		$unreadMessages = Message::where(['to_user_id'=>Auth::user()->id, 'read'=>false])->orderBy('created_at', 'desc')->paginate(8);
		return $unreadMessages;
	}

	public function messages() {
		$messages = Message::where('to_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(8);
		return $messages;
	}

	public function sentMessages() {
		$sentMessages = Message::where('from_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(8);
		return $sentMessages;
	}
}
