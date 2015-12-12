@extends('layout.task')


@section('content')
	<div class="container">
		<ul class='task-procedure first'>
			<li class="first col-md-4">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div>
	<div class="container">
		<h1>Publish you task</h1>
		{{Form::open(['url'=>'task/new/set-reward', 'method'=>'get'])}}
		{{Form::token()}}
			<div class="form-group">
				{{Form::text('title', '', ['placeholder'=>'title', 'class'=>'form-control'])}}
			</div>
			<div class="form-group">
				{{Form::textarea('detail', '', ['placeholder'=>'detail', 'class'=>'form-control'])}}
			</div>
			<div class="form-group">
				{{Form::submit('Continue', ['class'=>'btn btn-primary'])}}
			</div>
		{{Form::close()}}

		@if (count($errors->all()))
			<div class="alert alert-danger">
				@foreach ($errors->all() as $error)
					<p>{{$error}}</p>
				@endforeach
			</div>
		@endif
		
	</div>
@stop