@extends('layout.task')


@section('content')
	<div class="container">
		<ul class='task-procedure first'>
			<li class="first col-md-4">CREATE DEMAND</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div>
	<div class="container">
		<h1>Publish you demand</h1>
		{{Form::open(['url'=>'demand/new/set-reward', 'method'=>'get', 'class'=>'form-custom'])}}
		{{Form::token()}}
			<div class="form-group">
				{{Form::text('title', '', ['placeholder'=>'Title', 'class'=>'form-control'])}}
			</div>
			<div class="form-group">
				{{Form::textarea('detail', '', ['placeholder'=>'Detail', 'class'=>'form-control'])}}
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