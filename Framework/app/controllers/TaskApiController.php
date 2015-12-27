<?php

class TaskApiController extends BaseController {

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

}