<?php

class AdminController extends BaseController {
	public function auth() {
		return View::make('admin.auth');
	}


	public function studentCardPreview($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		return View::make('admin.studentCardPreview')
			->with('user_id', $user_id)
			->with('user', $user);
		return Redirect::back();
	}





	public function academy() {
		$academies = Academy::orderBy('created_at', 'desc')->get();
		return View::make('admin.academy')
			->with('academies', $academies);
	}

	public function postAcademy() {
		$userInput = [
			'name' => Input::get('name')
		];
		$rules = [
			'name' => 'required'
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			$academy = new Academy;
			$academy->name = $userInput['name'];
			$academy->save();
			return Redirect::to('/admin/academy');
		} else {
			return Redirect::to('/admin/academy')
				->withErrors($validator);
		}
	}


	public function academyDetail($academy_id) {
		$academy = Academy::where('id', $academy_id)->first();
		$majors = $academy->major;
		return View::make('admin.academyDetail')
			->with('academy', $academy)
			->with('majors', $majors);
	}

	public function postMajor($academy_id) {
		$userInput = [
			'name' => Input::get('major_name'),
			'academy_id' => $academy_id
		];
		$rules = [
			'name' => 'required',
		];
		$validator = Validator::make($userInput, $rules);
		if ($validator->passes()) {
			$major = new Major();
			$major->name = $userInput['name'];
			$major->academy_id = $userInput['academy_id'];
			$major->save();
			return Redirect::to("/admin/academy/$academy_id");
		} else {
			return Redirect::to("/admin/academy/$academy_id")
				->withErrors($validator);
		}

	}

}