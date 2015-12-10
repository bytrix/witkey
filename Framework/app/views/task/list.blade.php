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

		<div class="list-group list-group-lg">
			@foreach ($tasks as $task)
				<a href="/task/{{$task->id}}" class="list-group-item">
						
							<span>{{$task->title}}</span>
							<span class="created_at">{{explode(' ', $task->created_at)[0]}}</span>
							<span class="badge">&yen; {{$task->amount}}</span>
						
						{{-- <h2>{{HTML::link('task/'.$task->id, $task->title)}}</h2> --}}
						{{-- <span>{{$task->user->username}} ({{$task->user->email}})</span> --}}
				</a>
			@endforeach
		</div>
	</div>
@stop