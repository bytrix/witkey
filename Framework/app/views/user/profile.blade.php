@extends('task.master')

@section('menu')
	<ul class="nav navbar-nav">

	<li><a href="/">Home</a></li>
	<li><a href="/task/list">Task List</a></li>
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

@section('content')
	<div class="container">


		<div class="col-md-8">
			<div class="page-header">
				<h1>User info</h1>
			</div>






		<div class="row clearfix">
			<div class="col-md-12 column">
				<div class="tabbable" id="tabs-752296">
					<ul class="nav nav-tabs">
						<li class="active">
							 <a href="#panel-822933" data-toggle="tab">His Task</a>
						</li>
						<li>
							 <a href="#panel-486166" data-toggle="tab">Comments</a>
						</li>
					</ul>
					
					<div class="tab-content">
						<div class="tab-pane active" id="panel-822933">
{{-- 
							@if (count(Task::where('user_id', $user->id)->get()))
								@foreach (Task::where('user_id', $user->id)->get() as $task)
									<li>{{$task->title}}</li>
								@endforeach
							@else
								<p>No task published</p>
							@endif
							 --}}
							 <?php $tasks = $user->task()->paginate(10) ?>
							 @if (count($tasks))
								 @foreach ($tasks as $task)
								 	<li>{{$task->title}}</li>
								 @endforeach
							 @else
							 	<p class="alert alert-danger">No task done.</p>
							 @endif
							{{-- Paginator --}}
							{{$tasks->links()}}

						</div>
						<div class="tab-pane" id="panel-486166">
							<p>
								List the comments for his task
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>









		</div>

		<div class="col-md-4">
			<div class="profile">
				<div>
					<img src="{{URL::asset('/avatar/' . $user->avatar )}}" class="thumbnail">
				</div>
				<h4>
					{{$user->username}}
					@if ($user->active == 0)
						<span class="label label-danger">[ Inactive ]</span>
					@endif
					<span>
						{{-- <img src="{{URL::asset('assets/image')}}{{$user->gender == 'M' ? '/iconfont-genderman.png' : '/iconfont-genderwoman.png' }}"> --}}
						@if ($user->gender == 'M')
							<i class="fa fa-mars"></i>
						@elseif($user->gender == 'F')
							<i class="fa fa-venus"></i>
						@endif
					</span>
				</h4>
				<p>{{$user->email}}</p>


				<p>
					@if ($user->authenticated == 0)
						<span class="label label-danger">Not Authenticated</span>
					@endif
				</p>

				<p>Joined on {{explode(' ', $user->created_at)[0]}}</p>


				<p data-toggle="tooltip" title="School" data-placement="left">
					@if ($user->school != NULL)
						<i class="fa fa-map-marker"></i>
						{{Academy::getAcademy($user->school)}}
					@endif
				</p>

				<p data-toggle="tooltip" title="Major" data-placement="left">
					@if ($user->major != NULL)
						{{Academy::getMajor($user->major)}}
					@endif
				</p>

				<p data-toggle="tooltip" title="Grade" data-placement="left">
					@if ($user->enrollment_date != NULL)
						{{$grade}}
					@endif
				</p>

				<div>
					<strong>Skill Tag</strong>
					<div>
						@foreach (explode(',', $user->skill_tag) as $tag)
							<span class="label label-info">{{$tag}}</span>
						@endforeach
					</div>
				</div>

			</div>
		</div>



	</div>
@stop