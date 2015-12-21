<?php

class TaskApiController extends BaseController {

	public function hasFavoriteTask($tid) {

		if (Auth::user()->hasFavoriteTask($tid)) {

			return 'true';

		} else {

			return 'false';

		}

	}

	public function markFavoriteTask($tid) {

		if (Auth::user()->hasFavoriteTask($tid)) {

			Auth::user()->removeFavoriteTask($tid);
			return 'remove';

		} else {

			Auth::user()->markFavoriteTask($tid);
			return 'create';

		}

	}

	// public function removeFavoriteTask($tid) {
	// 	Auth::user()->removeFavoriteTask($tid);
	// }


	public function postCommit($id) {

		$isBidder = Auth::user()->isBidder($id);

		if (!$isBidder) {

			$task_bidder            = new TaskBidder;
			$task_bidder->task_id   = $id;
			$task_bidder->bidder_id = Auth::user()->id;
			$task_bidder->save();

		}

		return Redirect::to("/task/$id");

	}

	public function postQuit($id) {

		$isBidder = Auth::user()->isBidder($id);

		if ($isBidder) {

			$task_bidder = TaskBidder::where([
				'task_id'   => $id,
				'bidder_id' => Auth::user()->id
			]);
			$task_bidder->delete();
			// $task_bidder = new TaskBidder;
			// $task_bidder->task_id = $id;
			// $task_bidder->bidder_id = Auth::user()->id;
			// $task_bidder->save();
		}

		return Redirect::to("/task/$id");

	}

	public function postFavorite($tid) {
		// return $tid;
		// $taskfavorite_user = TaskfavoriteUser::create(['task_favoriteed_id'=>$tid, 'user_id'=>Auth::user()->id]);
		$taskfavorite_user          = new TaskfavoriteUser;
		$taskfavorite_user->task_id = $tid;
		$taskfavorite_user->user_id = Auth::user()->id;
		$taskfavorite_user->save();
		return 'ok';
	}

}