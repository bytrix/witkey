@extends('layout.task')

@section('menu')
	<ul class="nav navbar-nav">

	<li><a href="/">Home</a></li>
	<li><a href="/task/new">Publish Task</a></li>
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

@section('style')
<style>
.metadata,
.metadata a{
	color: #888;
	text-decoration: none;
}
.metadata a:hover{
	color: #666;
}
.metadata .property{
	margin-left: 10px;
}
.item-inline{
	display: inline-block;
}
.amount{
	font-size: 16px;
	margin-bottom: 5px;
}
.list-group-item-heading>a{
	color: #000;
}
.avatar-sm{
	float: left;
}
</style>

@stop

@section('content')
	<div class="container">
		<h1>Task List</h1>
		@if (count($tasks))
			<div class="list-group list-group-lg">
				@foreach ($tasks as $task)
					<div href="/task/{{$task->id}}" class="list-group-item">


						<div class="item-inline">
							<img class="avatar-sm img-rounded" src="{{UserController::getGravatar($task->user->email)}}" alt="">
						</div>

						<div class="item-inline">

							<h4 class="list-group-item-heading">
								<span class="amount badge">&yen; {{$task->amount}}</span>
								<a href="/task/{{$task->id}}">{{$task->title}}</a>
							</h4>
								<span class="metadata">
									<a href="/user/{{$task->user->id}}" class="property">
										<i class="icon-user"></i> {{$task->user->username}}
									</a>
									<i class="icon-calendar property"></i> {{explode(' ', $task->created_at)[0]}}
								</span>
							
						</div>

						{{-- <div class="item-inline"> --}}
							{{-- <span class="badge">&yen; {{$task->amount}}</span> --}}
						{{-- </div> --}}

					</div>
				@endforeach
			</div>
		@else
			<div class="alert alert-danger">No task published ever!</div>
		@endif
	</div>
@stop