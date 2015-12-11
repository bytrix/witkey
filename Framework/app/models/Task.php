<?php

class Task extends Eloquent {

	protected $table = 'Task';

	public function user() {
		return $this->belongsTo('User');
	}

	public function scopeRecent($query) {
        return $query->orderBy('created_at', 'desc');
	}
	
}