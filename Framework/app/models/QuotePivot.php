<?php

class QuotePivot extends Eloquent {

	protected $table = 'QuotePivot';

	public function user() {
		return $this->belongsTo('User');
	}

	public function task() {
		return $this->belongsTo('Task');
	}

	public function latestCommit() {
		return $this->hasMany('CommitPivot', 'quote_id', 'id')->orderBy('created_at', 'desc')->take(1);
	}

	public function historyCommits() {
		return $this->hasMany('CommitPivot', 'quote_id', 'id');
	}
}