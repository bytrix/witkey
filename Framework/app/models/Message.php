<?php

class Message extends Eloquent {

	protected $table = 'Message';

	public function from_user() {
		return $this->belongsTo('User', 'from_user_id')->first();
	}

	public function setMessageAttribute($message) {

		$this->attributes['message'] = Purifier::clean($message);
	}
}