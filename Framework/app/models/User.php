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
	public function orders() {
		return $this->hasMany('Task')->orderBy('created_at', 'desc');
	}


	// bidder(n) -------------- task(n)
	public function tasks() {
		return $this->belongsToMany('Task', 'Task_Bidder', 'bidder_id', 'task_id')->orderBy('created_at', 'desc');
		// return $this->belongsToMany('Task', 'Task_Bidder', 'bidder_id', 'task_id');
	}

	public function favoriteTasks (){
		return $this->belongsToMany('Task', 'TaskFavorite_User', 'user_id', 'task_favorite_id');
	}


	// winning_bidder(1) -------------- overdue_task(n)
	public function overdueTasks() {
		return $this->hasMany('Task', 'winning_bidder_id');
	}

	public function isBidder($taskId) {
		$arr = TaskBidder::where(['task_id'=>$taskId, 'bidder_id'=>Auth::user()->id])->get();
		if (count($arr)) {
			return true;
		} else {
			return false;
		}
	}

	public function asteriskTel() {
		$phoneNumber = $this->tel;
		$headNumber = substr($phoneNumber, 0, 3);
		$tailNumber = substr($phoneNumber, -3);
		$asteriskBody = '';
		for ($i=0; $i < strlen($phoneNumber)-6; $i++) { 
			$asteriskBody .= '*';
		}
		return $headNumber . $asteriskBody . $tailNumber;
	}

	public function asteriskDorm() {
		$dorm = $this->dorm;
		$headDorm = mb_substr($dorm, 0, 1);
		$tailDorm = mb_substr($dorm, -1);
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
		$taskfavorite_user = TaskfavoriteUserPivot::where(['task_favorite_id'=>$tid, 'user_id'=>Auth::user()->id])->first();
		if (count($taskfavorite_user)) {
			return true;
		} else {
			return false;
		}
	}

	public function markFavoriteTask($tid) {
		$taskfavorite_user = new TaskfavoriteUserPivot;
		$taskfavorite_user->task_favorite_id = $tid;
		$taskfavorite_user->user_id = Auth::user()->id;
		$taskfavorite_user->save();
	}

	public function removeFavoriteTask($tid) {
		$taskfavorite_user = TaskfavoriteUserPivot::where(['task_favorite_id'=>$tid, 'user_id'=>Auth::user()->id]);
		$taskfavorite_user->delete();
	}
	// END POST API PART


}
