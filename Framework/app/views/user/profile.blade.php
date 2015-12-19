@extends('layout.task')

@section('menu')
	<ul class="nav navbar-nav">

	<li><a href="/">Home</a></li>
	<li><a href="/task/list">Task List</a></li>
	<li><a href="/task/new">Publish Task</a></li>
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
							 <?php $tasks = $user->tasks()->paginate(10) ?>
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
					<img src="{{UserController::getGravatar($user->email)}}" class="thumbnail">
				</div>
				<h4>{{$user->username}}</h4>
				<p>{{$user->email}}</p>

				<span>
					{{-- <img src="{{URL::asset('assets/image')}}{{$user->gender == 'M' ? '/iconfont-genderman.png' : '/iconfont-genderwoman.png' }}"> --}}
					@if ($user->gender == 'M')
						<i class="fa fa-mars"></i>
					@elseif($user->gender == 'F')
						<i class="fa fa-venus"></i>
					@endif
				</span>
				<p>Joined on {{explode(' ', $user->created_at)[0]}}</p>


				<p>
					<?php
						$schoolAge = Utility::Sec2Year(strtotime(date('Y-m-d')) - strtotime($user->enrollment_date));
					?>
					{{Utility::grade($schoolAge)}}
				</p>


				<p>
					@if ($user->school == NULL)
						<p class="text-danger">No School</p>
					@else
						<i class="fa fa-map-marker"></i>
						{{UserController::$schoolList[$user->school]}}
					@endif
				</p>

				<p>
					@if ($user->major == NULL || $user->major_category == NULL)
						<p class="text-danger">No Major</p>
					@else
						{{UserController::$majorCategoryList[$user->major_category]}}
						-
						{{UserController::$majorList[$user->major]}}
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