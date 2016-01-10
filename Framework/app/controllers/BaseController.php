<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
		View::share('mySchool', $this->mySchool());
		View::share('schools', $this->allSchools());
	}

	public function mySchool() {
		$academy_id = Session::get('school_id_session');
		$mySchool = Academy::where('id', $academy_id)->first();
		return $mySchool;
	}

	public function allSchools() {
		$academies = Academy::all();
		return $academies;
	}

}
