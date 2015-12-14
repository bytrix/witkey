@extends('layout.task')

@section('menu')
	<ul class="nav navbar-nav">

	<li><a href="/">Home</a></li>
	<li><a href="/demand/new">Publish Demand</a></li>
	<li class="active"><a href="/task/list">Task List</a></li>
	<li class="dropdown">
	  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	    <li><a href="/about">About</a></li>
	    {{-- <li><a href="/contact">Contact</a></li> --}}
	  </ul>
	</li>

	</ul>

@stop

@section('content')
	<div class="container">


		<div class="col-md-8">
			<div class="page-header">
				<h1>{{$task->title}}</h1>
			</div>

			<div class="col-sm-6">
				<h4><strong>Task ID:</strong> #{{$task->id}}</h4>
				<h4><strong>Task Amount:</strong> &yen;{{$task->amount}}</h4>
			</div>


			<div class="col-sm-6">
				<h4><strong>School location:</strong> {{$task->user->school}}</h4>
				<h4><strong>Expiration:</strong> {{explode(' ', $task->expire)[0]}}</h4>
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
				<p>
					{{$task->detail}}
				</p>


				{{-- logined user --}}
				@if (Auth::check())

					{{-- the demand belongs to the logined user --}}
					@if ($task->user_id == Auth::user()->id)

						{{-- THIS IS YOUR DEMAND --}}
						<a href="#" class="btn btn-success">Close demand</a>

					{{-- other logined user --}}
					@else

						{{-- user has recruit the task --}}
						@if (Auth::user()->whetherEnroll($id))
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
			</div>
		</div>

		<div class="col-md-4">
			<div class="profile">
				<div>
					<img src="{{UserController::get_gravatar($task->user->email)}}" class="thumbnail">
				</div>
				<h4>{{$task->user->username}}</h4>


				<span>
					<img src="{{URL::asset('assets/image')}}{{$task->user->gender == 'M' ? '/iconfont-genderman.png' : '/iconfont-genderwoman.png' }}">
				</span>
				<p>Joined on {{explode(' ', $task->user->created_at)[0]}}</p>

				@if (strlen($task->user->tel))
					@if (Auth::check())
						@if (Auth::user()->whetherEnroll($id) || ($task->user_id == Auth::user()->id))
							<p><i class="icon-phone"></i> {{$task->user->tel}}</p>
						@else
							<p><i class="icon-phone"></i> {{$task->user->asteriskTel()}}</p>
						@endif
					@endif
				@endif

				@if (strlen($task->user->dorm))
					@if (Auth::check())
						@if (Auth::user()->whetherEnroll($id) || ($task->user_id == Auth::user()->id))
							<p><i class="icon-map-marker"></i> {{$task->user->dorm}}</p>
						@else
							<p><i class="icon-map-marker"></i> {{$task->user->asteriskDorm()}}</p>
						@endif
					@endif
				@endif




			</div>
		</div>



	</div>
@stop