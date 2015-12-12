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
.created_at{
	margin-left: 8px;
	color: #888;
}
</style>
@stop

@section('content')
	<div class="container">
		<h1>Task List</h1>
		@if (count($tasks))
			<div class="list-group list-group-lg">
				@foreach ($tasks as $task)
					<a href="/task/{{$task->id}}" class="list-group-item">
						<h4 class="list-group-item-heading">{{$task->title}}</h4>
							<span class="created_at">
								<i class="icon-user"></i> {{$task->user->username}}
								<i class="icon-calendar"></i> {{explode(' ', $task->created_at)[0]}}
							</span>
						<span class="badge">&yen; {{$task->amount}}</span>
					</a>
				@endforeach
			</div>
		@else
			<div class="alert alert-danger">No task published ever!</div>
		@endif
	</div>
@stop