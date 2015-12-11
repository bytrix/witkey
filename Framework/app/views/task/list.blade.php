@extends('layout.task')

@section('style')
<style>
.created_at{
	margin-left: 30px;
	float: right;
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
						<span>{{$task->title}}</span>
						<span class="created_at">{{$task->user->username}} create at {{explode(' ', $task->created_at)[0]}}</span>
						<span class="badge">&yen; {{$task->amount}}</span>
					</a>
				@endforeach
			</div>
		@else
			<div class="alert alert-danger">No task published ever!</div>
		@endif
	</div>
@stop