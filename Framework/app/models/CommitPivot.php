<?php

class CommitPivot extends Eloquent {

	protected $table = 'CommitPivot';

	public function user() {
		return $this->belongsTo('User');
	}
	
	public function task() {
		return $this->belongsTo('Task');
	}

	public function comment() {
		return $this->hasOne('Comment', 'id', 'comment_id');
	}
}