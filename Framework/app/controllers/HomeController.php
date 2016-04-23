<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index() {

		$academies = Academy::all();

		// $academy_id = Session::get('school_id_session');
		$academy_id = Cookie::get('school_id_session');
		$school = Academy::where('id', $academy_id)->first();
		// dd(var_dump($school));

		if ($school != NULL) {
			return Redirect::to("/school/$academy_id");
		}

		return View::make('home.index')
			->with('academies', $academies);

	}

	public function help() {
		
		return View::make('layout.help');
	}
}
