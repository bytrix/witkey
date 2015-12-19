<?php

class ApiController extends BaseController {

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
		// return 'Ok!';
		// return 'login';
	}

	public function removeFavoriteTask($tid) {
		Auth::user()->removeFavoriteTask($tid);
		// return 'removed';
	}
}