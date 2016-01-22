<?php

class Task extends Eloquent {

	protected $table = 'Task';

	// demand(n) -------------- user(1)
	public function user() {
		return $this->belongsTo('User');
	}

	// task(n) -------------- bidder(n)
	public function bidder() {
		if ($this->type == 1) {
			return $this->belongsToMany('User', 'CommitPivot', 'task_id', 'user_id')->distinct();
		} else if($this->type == 2) {
			return $this->belongsToMany('User', 'QuotePivot', 'task_id', 'user_id')->distinct();
		}
	}

	// public function quotesDistinctByUser() {
	// 	return $this->hasMany('QuotePivot', 'id', 'quote_id')->whereIn('user_id', [1]);
	// }

	// overdue_task(n) -------------- winning_bidder(1)
	// public function winningBidder() {
	// 	return $this->belongsTo('User', 'winning_bidder_id');
	// }
	public function winningCommit() {
		return $this->hasOne('CommitPivot', 'id', 'winning_commit_id');
	}

	public function winningQuote() {
		return $this->hasOne('QuotePivot', 'id', 'winning_quote_id');
	}

	public function scopeRecent($query) {
        return $query->orderBy('created_at', 'desc');
	}

	public function scopeActiveUserFilter($query) {
		if ($this->user->active == 0) {
			return 'inactive';
		}
		return 'active';
	}

	public function category() {
		return $this->belongsTo('Category');
	}

	public function attachment() {
		return $this->hasOne('Attachment', 'task_id');
	}

	// public function setTitleAttribute($data) {
	// 	$this->attributes['title'] = Purifier::clean($data);
	// }

	// public function setDetailAttribute($data) {
	// 	$this->attributes['detail'] = Purifier::clean($data);
	// }
	
}