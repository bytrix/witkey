<?php

class Comment extends Eloquent {

	protected $table = 'Comment';

	public function commit() {
		return $this->belongsTo('CommitPivot');
	}

	public function commenter() {
		return $this->belongsTo('User', 'from_whom_id');
	}

	public function byCommenter() {
		return $this->belongsTo('User', 'user_id');
	}
}