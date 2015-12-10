@extends('layout.task')

@section('content')
	<div class="container">
		<ul class='task-procedure third'>
			<li class="first col-md-4">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div>
	<div class="container">

		<h1>success</h1>
		<p><h2>{{Session::get('title')}}</h2></p>
		<p>Reward: &yen;{{Session::get('amount')}}</p>
		<p>
			<span>Task description: </span>
			<br>
			{{Session::get('detail')}}
		</p>
		{{HTML::link('task/new/postTask', 'Publish', ['class'=>'btn btn-primary'])}}
	</div>
@stop
