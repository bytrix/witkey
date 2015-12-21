<?php

class Task extends Eloquent {

	protected $table = 'Task';

	// demand(n) -------------- user(1)
	public function user() {
		return $this->belongsTo('User');
	}

	// task(n) -------------- bidder(n)
	public function bidder() {
		return $this->belongsToMany('User', 'QuotePivot', 'task_id', 'user_id');
	}

	// overdue_task(n) -------------- winning_bidder(1)
	public function winningBidder() {
		return $this->belongsTo('User', 'winning_bidder_id');
	}

	public function scopeRecent($query) {
        return $query->orderBy('created_at', 'desc');
	}

	public function setTitleAttribute($data) {
		$this->attributes['title'] = e("$data");
	}

	public function setDetailAttribute($data) {
		$this->attributes['detail'] = e("$data");
	}
	
}