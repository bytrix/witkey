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

		return $this->belongsToMany('Task', 'CommitPivot', 'user_id', 'task_id')
			->distinct()
			->orderBy('created_at', 'desc');
		// return Task::where('user_id', Auth::user()->id);
		// return $this->hasMany('Task', 'user_id', 'id');
	}

	public function hasWinTask($task_id) {
		// return $this->username;
		$task = Task::where('id', $task_id)->first();
		$winning_commit = CommitPivot::where('id', $task->winning_commit_id)->first();
		// return $task->winning_commit->user->id;
		// return $this->id;
		// return !$task->winning_commit_id;
		if ($task->winning_commit_id != 0) {
			if ($winning_commit->user->id == $this->id) {
				return true;
			}
		}
		return false;
	}

	// commenter->comments_from()
	public function commentsFrom() {
		return $this->hasMany('CommitPivot', 'from_whom_id', 'id');
	}

	// byCommenter->comments_to()
	public function commentsTo() {
		return $this->hasMany('CommitPivot', 'user_id', 'id');
	}

	// public function quote() {

	// 	return $this->belongsToMany('Task', 'QuotePivot', 'user_id', 'task_id')
	// 		->orderBy('created_at', 'desc');
	// }

	// public function commit() {

	// 	return $this->belongsToMany('Task', 'CommitPivot', 'user_id', 'task_id')
	// 		->orderBy('created_at', 'desc');
	// }

	public function findLatestCommitById($user_id, $task_id) {
		// return $this->belongsToMany('Task', 'CommitPivot', 'task_id', 'user_id');
		// return $this->hasMany('CommitPivot', 'user_id', 'id');
		return DB::table('User')
			->leftJoin('CommitPivot', 'User.id', '=', 'CommitPivot.user_id')
			->where(['user_id'=>$user_id, 'task_id'=>$task_id])
			->orderBy('CommitPivot.created_at', 'desc')
			->take(1);
	}

	public function findLatestQuoteById($user_id, $task_id) {
		// return $this->hasMany('QuotePivot', 'user_id', 'id')->orderBy('created_at', 'desc');
		return DB::table('User')
			->leftJoin('QuotePivot', 'User.id', '=', 'QuotePivot.user_id')
			->where(['user_id'=>$user_id, 'task_id'=>$task_id])
			->orderBy('QuotePivot.created_at', 'desc')
			->take(1);
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


	// public function setPasswordAttribute($data) {

	// 	$this->attributes['password'] = Hash::make($data);
	// }








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

	public function hasFriend($user_id) {
		$friend = FriendPivot::where(['user_id'=>Auth::user()->id, 'friend_id'=>$user_id])->get();
		if (count($friend)) {
			return true;
		} else {
			return false;
		}
	}

	public function friend() {
		return $this->belongsToMany('User', 'FriendPivot', 'user_id', 'friend_id');
	}

	public function tag() {
		$tag = explode(',', Auth::user()->skill_tag);
		return $tag;
	}

	public function school() {
		return $this->belongsTo('Academy', 'id');
	}

}
