@extends('task.master')

@section('content')
	<div class="container">
		<h1>Success</h1>
			<p>
				You have paid &yen;{{$task->amount}} to {{$commit->user->username}} successfully!
			</p>
			<a href="/task/{{$task->id}}" class="btn btn-default">
				Back
			</a>
	</div>
@stop