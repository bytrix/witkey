<?php

class QuotePivot extends Eloquent {

	protected $table = 'QuotePivot';

	public function user() {
		return $this->belongsTo('User');
	}
}