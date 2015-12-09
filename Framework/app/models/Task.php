<?php

class Goods extends Eloquent {

	protected $table = 'Task';

	public function User() {
		return $this->belongsTo('User');
	}
	
}