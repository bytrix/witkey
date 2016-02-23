<?php

class Major extends Eloquent {

	protected $table = 'Major';

	public function academy() {
		return $this->belongsTo('Academy');
	}

	public static function get($major_id) {
		$major = Major::where('id', $major_id)->first();
		return $major;
	}
}