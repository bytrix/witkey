<?php

class ApiController extends BaseController {

	public function hasFavoriteTask($task_id) {

		if (Auth::user()->hasFavoriteTask($task_id)) {
			return 'true';

		} else {
			return 'false';
		}
	}

	public function markFavoriteTask($task_id) {

		if (Auth::user()->hasFavoriteTask($task_id)) {
			Auth::user()->removeFavoriteTask($task_id);
			return 'remove';

		} else {
			Auth::user()->markFavoriteTask($task_id);
			return 'create';
		}
	}

	public function taskState($task_id) {
		
		$task = Task::where('id', $task_id)->first();
		return $task->state;
	}

	public function authUser() {
		return Auth::user();
	}

	// public function removeFavoriteTask($task_id) {
	// 	Auth::user()->removeFavoriteTask($task_id);
	// }


	// public function postCommit($id) {

	// 	$isBidder = Auth::user()->isBidder($id);

	// 	if (! $isBidder) {

	// 		$task_bidder            = new TaskBidder;
	// 		$task_bidder->task_id   = $id;
	// 		$task_bidder->bidder_id = Auth::user()->id;
	// 		$task_bidder->save();

	// 	}

	// 	return Redirect::to("/task/$id");

	// }

	// public function postQuit($id) {

	// 	$isBidder = Auth::user()->isBidder($id);

	// 	if ($isBidder) {

	// 		$task_bidder = TaskBidder::where([
	// 			'task_id'   => $id,
	// 			'bidder_id' => Auth::user()->id
	// 		]);
	// 		$task_bidder->delete();
	// 		// $task_bidder = new TaskBidder;
	// 		// $task_bidder->task_id = $id;
	// 		// $task_bidder->bidder_id = Auth::user()->id;
	// 		// $task_bidder->save();
	// 	}

	// 	return Redirect::to("/task/$id");

	// }

	// public function postFavorite($task_id) {
	// 	// return $task_id;
	// 	// $taskfavorite_user = TaskfavoriteUser::create(['task_favoriteed_id'=>$task_id, 'user_id'=>Auth::user()->id]);
	// 	$taskfavorite_user          = new TaskfavoriteUser;
	// 	$taskfavorite_user->task_id = $task_id;
	// 	$taskfavorite_user->user_id = Auth::user()->id;
	// 	$taskfavorite_user->save();
	// 	return 'ok';
	// }


	public function allAcademies() {
		return Academy::all();
	}

	public static function getAcademy($academy_id) {
		$academy = Academy::where('id', $academy_id)->first();
		return $academy;
	}

	public static function allMajors() {
		return Major::all();
	}

	public static function getMajor($major_id) {
		$major = Major::where('id', $major_id)->first();
		return $major;
	}


	public function getUsers() {
		return User::orderBy('authenticated')->get([
				'id',
				'authenticated',
				'realname',
				'username',
				'email',
				'student_card',
				'school',
				'major',
				'enrollment_date'
			]);
	}

	public function postAuthTobe($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		if ($user->authenticated != 0) {
			$user->authenticated = 1;
			$user->save();
		}
		return Redirect::back();
	}

	public function postAuthSuccess($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		if ($user->authenticated != 0) {
			$user->authenticated = 2;
			$user->save();
		}
		return Redirect::back();
	}

	public function postAuthFail($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		if ($user->authenticated != 0) {
			$user->authenticated = 3;
			$user->save();
		}
		return Redirect::back();
	}
}