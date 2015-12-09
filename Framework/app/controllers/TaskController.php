<?php

class TaskController extends BaseController {
	public function index() {
		return View::make('task.index');
	}
}