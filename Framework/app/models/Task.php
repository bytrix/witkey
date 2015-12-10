<?php

class Task extends Eloquent {

	protected $table = 'Task';

	public function user() {
		return $this->belongsTo('User');
	}
	
}