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

	// To check the current logined user whether is bidder of some task given by task_id
	public function isBidder($task_id) {

		$task = Task::where(['id'=>$task_id])->first();

		if ($task->type == 1) {
			$bidder_array = CommitPivot::where([
				'task_id'   =>$task_id,
				'user_id' =>Auth::user()->id
			])->get();
		} else if ($task->type ==2) {
			$bidder_array = QuotePivot::where([
				'task_id'   =>$task_id,
				'user_id' =>Auth::user()->id
			])->get();
		}

		if (count($bidder_array)) {
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
		
		return Util::asterisk($this->tel, 1, 1);
	}

	public function asteriskQQ() {

		return Util::asterisk($this->qq, 1, 1);
	}

	public function asteriskDorm() {

		return Util::asterisk($this->dorm, 1, 1);
	}

	public function asteriskResident() {

		return '***';
	}


	public function setPasswordAttribute($data) {

		$this->attributes['password'] = Hash::make($data);
	}











	// POST API PART
	// if Auth user favorite some task, return true, else return false
	public function hasFavoriteTask($task_id) {

		$favorite_task = FavoriteTaskPivot::where(['task_id'=>$task_id, 'user_id'=>Auth::user()->id])->first();

		if (count($favorite_task)) {
			return true;

		} else {
			return false;
		}
	}

	public function markFavoriteTask($task_id) {

		$favorite_task          = new FavoriteTaskPivot;
		$favorite_task->task_id = $task_id;
		$favorite_task->user_id = Auth::user()->id;
		$favorite_task->save();
	}

	public function removeFavoriteTask($task_id) {

		$favorite_task = FavoriteTaskPivot::where(['task_id'=>$task_id, 'user_id'=>Auth::user()->id]);
		$favorite_task->delete();
	}
	// END POST API PART



	public function hasUserById($user_id) {
		$user = User::where(['id'=>$user_id])->first();
		if ($user) {
			return true;
		} else {
			return false;
		}
	}


}
