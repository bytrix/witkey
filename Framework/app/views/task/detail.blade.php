@extends('layout.task')

@section('content')
	<div class="container">
		<h1>{{$task->title}}</h1>
		<p>
			{{$task->detail}}
		</p>
	</div>
@stop