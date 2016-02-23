<?php

class Category extends Eloquent {

	protected $table = 'Category';

	public function task() {

		return $this->hasMany('Task');
	}
}