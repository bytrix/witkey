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
		<h1 class="page-header">Publish you demand</h1>
		{{Form::open(['url'=>'demand/new/set-reward', 'method'=>'post', 'class'=>'form-custom'])}}
			<div class="form-group">
				{{Form::label('title', 'Title', ['class'=>'control-label'])}}
				{{Form::text('title', Session::get('title'), ['placeholder'=>'Title', 'class'=>'form-control'])}}
			</div>
			<div class="form-group">
				{{Form::label('detail', 'Detail', ['class'=>'control-label'])}}
				{{Form::textarea('detail', Session::get('detail'), ['placeholder'=>'Detail', 'class'=>'form-control'])}}
			</div>
			<div class="form-group">
				{{Form::submit('Next', ['class'=>'btn btn-primary'])}}
				{{-- {{HTML::link('demand/new/set-reward', 'Next', ['class'=>'btn btn-primary'])}} --}}
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