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
	public function demands() {
		return $this->hasMany('Task')->orderBy('created_at', 'desc');
	}


	// bidder(n) -------------- task(n)
	public function tasks() {
		return $this->belongsToMany('Task', 'Task_Bidder', 'bidder_id')->orderBy('created_at', 'desc');
	}


	// winning_bidder(1) -------------- overdue_task(n)
	public function overdueTasks() {
		return $this->hasMany('Task', 'winning_bidder_id');
	}

	public function whetherEnroll($taskId) {
		$arr = TaskBidder::where(['task_id'=>$taskId, 'bidder_id'=>Auth::user()->id])->get();
		if (count($arr)) {
			return true;
		} else {
			return false;
		}
	}


	public function setPasswordAttribute($data) {
		$this->attributes['password'] = Hash::make($data);
	}

}
