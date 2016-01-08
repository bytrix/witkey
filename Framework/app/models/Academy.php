<?php

class Academy extends Eloquent {

	protected $table = 'Academy';

	public function major() {
		return $this->hasMany('Major');
	}

	// public static function allAcademies() {
	// 	// $schoolList = array();
	// 	// foreach (Academy::get(['name']) as $school) {
	// 	// 	array_push($schoolList, $school->name);
	// 	// }
	// 	// return $schoolList;
	// 	return Academy::all();
	// }


	public static function get($academy_id) {
		$academy = Academy::where('id', $academy_id)->first();
		return $academy;
	}



}