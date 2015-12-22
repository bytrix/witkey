<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'User';


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	// user(1) -------------- demand(n)
	public function order() {

		return $this->hasMany('Task')
			->orderBy('created_at', 'desc');
	}


	// bidder(n) -------------- task(n)
	public function task() {

		return $this->belongsToMany('Task', 'QuotePivot', 'user_id', 'task_id')
			->orderBy('created_at', 'desc');
		// return $this->belongsToMany('Task', 'Task_Bidder', 'bidder_id', 'task_id');
	}

	public function favoriteTask (){

		return $this->belongsToMany('Task', 'FavoriteTaskPivot', 'user_id', 'task_id');
	}


	// winning_bidder(1) -------------- overdue_task(n)
	// public function overdueTask() {

	// 	return $this->hasMany('Task', 'winning_bidder_id');
	// }

	public function isBidder($task_id) {

		$bidder_arrat = QuotePivot::where([
			'task_id'   =>$task_id,
			'user_id' =>Auth::user()->id
		])->get();

		if (count($bidder_arrat)) {

			return true;

		} else {

			return false;
		}
	}

	public function realname() {
		if (Auth::check()) {
			if (Auth::user()->authenticated == 2) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}

	public function asteriskTel() {
		$phoneNumber  = $this->tel;
		$headNumber   = substr($phoneNumber, 0, 3);
		$tailNumber   = substr($phoneNumber, -3);
		$asteriskBody = '';

		for ($i=0; $i < strlen($phoneNumber)-6; $i++) { 

			$asteriskBody .= '*';
		}

		return $headNumber . $asteriskBody . $tailNumber;
	}

	public function asteriskQQ() {
		$qqNumber  = $this->qq;
		$headNumber   = substr($qqNumber, 0, 3);
		$tailNumber   = substr($qqNumber, -3);
		$asteriskBody = '';

		for ($i=0; $i < strlen($qqNumber)-6; $i++) { 

			$asteriskBody .= '*';
		}

		return $headNumber . $asteriskBody . $tailNumber;
	}

	public function asteriskDorm() {

		$dorm         = $this->dorm;
		$headDorm     = mb_substr($dorm, 0, 1);
		$tailDorm     = mb_substr($dorm, -1);
		$asteriskBody = '';

		for ($i=0; $i < strlen($dorm)-2; $i++) { 

			$asteriskBody .= '*';
		}

		return $headDorm . $asteriskBody . $tailDorm;
	}


	public function setPasswordAttribute($data) {

		$this->attributes['password'] = Hash::make($data);
	}











	// POST API PART
	// if Auth user favorite some task, return true, else return false
	public function hasFavoriteTask($tid) {

		$favorite_task = FavoriteTaskPivot::where(['task_id'=>$tid, 'user_id'=>Auth::user()->id])->first();

		if (count($favorite_task)) {
			return true;

		} else {
			return false;
		}
	}

	public function markFavoriteTask($tid) {

		$favorite_task          = new FavoriteTaskPivot;
		$favorite_task->task_id = $tid;
		$favorite_task->user_id = Auth::user()->id;
		$favorite_task->save();
	}

	public function removeFavoriteTask($tid) {

		$favorite_task = FavoriteTaskPivot::where(['task_id'=>$tid, 'user_id'=>Auth::user()->id]);
		$favorite_task->delete();
	}
	// END POST API PART


}
