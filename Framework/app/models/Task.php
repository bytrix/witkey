<?php

class Task extends Eloquent {

	protected $table = 'Task';


	// demand(n) -------------- user(1)
	public function user() {
		return $this->belongsTo('User');
	}

	// task(n) -------------- bidder(n)
	public function bidders() {
		return $this->belongsToMany('User', 'Task_Bidder', 'bidder_id');
	}

	// overdue_task(n) -------------- winning_bidder(1)
	public function winningBidder() {
		return $this->belongsTo('User', 'winning_bidder_id');
	}

	public function scopeRecent($query) {
        return $query->orderBy('created_at', 'desc');
	}
	
}