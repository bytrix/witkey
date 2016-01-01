<?php

class CommitPivot extends Eloquent {

	protected $table = 'CommitPivot';

	public function user() {
		return $this->belongsTo('User');
	}
	
	public function task() {
		return $this->belongsTo('Task');
	}
}