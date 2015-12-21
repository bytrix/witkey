@extends('task.master')

@section('menu')
	<ul class="nav navbar-nav">

	<li><a href="/">Home</a></li>
	<li class="active"><a href="/task/list">Task List</a></li>
	<li><a href="/task/create">Publish Task</a></li>
	<li class="dropdown">
	  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	    <li><a href="/about">About</a></li>
	    {{-- <li><a href="/contact">Contact</a></li> --}}
	  </ul>
	</li>

	</ul>

@stop

@section('style')
<style>
  .avatar-sm{
    /*float: left;*/
    cursor: pointer;
    width: 30px;
    margin-right: 12px;
    margin-bottom: 4px;
  }
  .avatar-sm:hover{
    box-shadow: 0 0 2px #337ab7;
  }
</style>
@stop

@section('script')
<script>
	function favorite() {
		$('#favorite').addClass('fa-heart');
		$('#favorite').removeClass('fa-heart-o');
		$('#favorite').attr('data-original-title', 'Uncollect');
		$('#tip').html('Collected');
	}
	function unfavorite() {
		$('#favorite').removeClass('fa-heart');
		$('#favorite').addClass('fa-heart-o');
		$('#favorite').attr('data-original-title', 'Collect');
		$('#tip').html('Collect');
	}
	$(function() {
		$('#edit').click(function() {
			window.location.href = "/task/{{$task->id}}/edit";
		});
		$.ajax({
			type: 'post',
			url: '/hasFavoriteTask/'+{{$id}},
			success: function(state) {
				if (state == 'true') {
					favorite();
				} else if(state == 'false') {
					unfavorite();
				}
			}
		});
	});
</script>
@stop

@section('content')
	<div class="container">


		<div class="col-md-8">
			<div class="page-header">
				<h3>
					@if (strlen($task->title) > 40)
						<span title="{{$task->title}}" class="detail-title">
							{{str_limit($task->title, 40)}}
						</span>
					@else
						{{$task->title}}
					@endif
					<div class="pull-right">
						{{-- Edit Button --}}
						<div class="col-sm-6">
							@if (Auth::check())
								@if ($task->user_id == Auth::user()->id)
									<i class="fa fa-edit" id="edit" href="/task/{{$task->id}}/edit" data-toggle="tooltip" data-placement="top" title="Edit"></i>
								@endif
							@endif
						</div>
						<div class="col-sm-6">
							{{-- Favorite Button --}}
							<i class="fa fa-heart-o favorite" id="favorite" data-toggle="tooltip" data-placement="top" title="favorite"></i>
							<span id="tip">favorite</span>
						</div>
					</div>
				</h3>
				<script>

				$('#favorite').click(function() {
					$.ajax({
						type: 'post',
						url: '/markFavoriteTask/'+{{$id}},
						success: function(state) {
							if (state == 'remove') {
								unfavorite();
							} else if(state == 'create') {
								favorite();
							}
						},
						error: function(data) {
							console.log(data);
							window.location.href = '/login';
						}
					});
				});
				</script>
			</div>

			<div class="col-sm-6">
				<h4><strong>Task ID:</strong> #{{$task->id}}</h4>
				@if ($task->type == 1)
					<h4><strong>Reward:</strong> &yen;{{$task->amount}}</h4>
				@elseif ($task->type == 2)
					<h4><strong>Budget:</strong> &yen;{{$task->amount}}</h4>
				@endif
			</div>

			<div class="col-sm-6">
				<h4><strong>School location:</strong>
				@if ($task->user->school == NULL)
					<span class="label label-danger">No School</span>
				@else
					{{UserController::$schoolList[$task->user->school]}}</h4>
				@endif
				<h4><strong>Expiration:</strong> {{$task->expiration}}</h4>
				<p></p>
			</div>

			<div class="col-sm-12">


				<ul class='task-procedure first'>
					<li class="first col-md-3">Enrollment</li>
					<li class="second col-md-3">Carry out</li>
					<li class="third col-md-3">Check</li>
					<li class="third col-md-3">Finish</li>
				</ul>


				<h4><strong>Task Description:</strong></h4>
				<div class="detail" id="detail">
					{{{str_limit($task->detail, 1200)}}}
				</div>
				@if (strlen($task->detail) > 1200)
					<div>
						<a href="javascript:;" id="more">More</a>
					</div>
					<script>
					$('#more').click(function() {
						// alert($(this).html());
						$('#detail').html("{{$task->detail}}");
						if($(this).html() == 'Fold') {
							// alert('fold');
							$(this).html('More');
							$('#detail').html("{{str_limit($task->detail, 1200)}}");
						} else {
							$(this).html('Fold');
						}
					})
					</script>
				@endif

				<h4><strong>Bidders({{count($task->bidder)}}):</strong></h4>
				<div class="avatar-bar">
					@foreach ($task->bidder as $bidder)
						<img class='avatar-sm' onclick="window.location.href='/user/{{$bidder->id}}'" src="{{ThirdPartyController::getGravatar($bidder->email)}}" data-toggle="tooltip" title="{{$bidder->username}}" data-placement="top">
					@endforeach
				</div>



				{{-- logined user --}}
				@if (Auth::check())

					{{-- the task belongs to the logined user --}}
					@if ($task->user_id == Auth::user()->id)

						{{-- THIS IS YOUR TASK --}}
						<a href="#" class="btn btn-success">Close task</a>

					{{-- other logined user --}}
					@else

						{{-- user has recruit the task --}}
						@if (Auth::user()->isBidder($id))
							{{Form::open(['url'=>"/task/$id/quit"])}}
								{{Form::submit('Quit', ['class'=>'btn btn-danger'])}}
							{{Form::close()}}
						{{-- user hasn't recruit the task --}}
						@else
							{{Form::open(['url'=>"/task/$id/enrollment"])}}
								{{Form::submit('Enroll', ['class'=>'btn btn-primary'])}}
							{{Form::close()}}
						@endif

					@endif

				@else

					{{-- guest user --}}
					<button class="btn btn-primary disabled">Not logined yet!</button>

				@endif




				{{-- COMMIT AREA --}}
				@if ($task->type == 1)
					{{-- reward --}}
					{{Form::open()}}
						{{Form::label('post', 'Post your work')}}
						<div class="form-group">
							{{Form::textarea('post', '', ['class'=>'form-control'])}}
						</div>
						<div class="form-group">
							{{Form::submit('Commit', ['class'=>'btn btn-primary'])}}
						</div>
					{{Form::close()}}
				@elseif ($task->type == 2)
					{{-- bid --}}
				@endif
				{{-- END COMMIT AREA --}}



			</div>

		</div>

		<div class="col-md-4">
			<div class="profile">
				<div>
					<img src="{{ThirdPartyController::getGravatar($task->user->email)}}" class="thumbnail">
				</div>
				<h4><a href="/user/{{$task->user->id}}">{{$task->user->username}}</a></h4>


				<span>
					{{-- <img src="{{URL::asset('assets/image')}}{{$task->user->gender == 'M' ? '/iconfont-genderman.png' : '/iconfont-genderwoman.png' }}"> --}}
					@if ($task->user->gender == 'M')
						<i class="fa fa-mars"></i>
					@elseif($task->user->gender == 'F')
						<i class="fa fa-venus"></i>
					@endif
				</span>
				<p>Joined on {{explode(' ', $task->user->created_at)[0]}}</p>

				@if (strlen($task->user->tel))
					@if (Auth::check())
						@if (Auth::user()->isBidder($id) || ($task->user_id == Auth::user()->id))
							<p><i class="fa fa-phone"></i> {{$task->user->tel}}</p>
						@else
							<p><i class="fa fa-phone"></i> {{$task->user->asteriskTel()}}</p>
						@endif
					@endif
				@endif

				@if (strlen($task->user->dorm))
					@if (Auth::check())
						@if (Auth::user()->isBidder($id) || ($task->user_id == Auth::user()->id))
							@if ($task->user->dorm == 'no')
								<span class="label label-warning">Non-resident</span>
							@else
								<p><i class="fa fa-map-marker"></i> {{$task->user->dorm}}</p>
							@endif
						@else
							<p><i class="fa fa-map-marker"></i> {{$task->user->asteriskDorm()}}</p>
						@endif
					@endif
				@endif



			</div>
		</div>



	</div>
@stop