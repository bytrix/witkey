@extends('user.dashboard.dashboard')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
  	<li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/profile">Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/mytask">My Task</a></li>
    <li><a href="/dashboard/certification">Real-name Certification</a></li>
    <li class="active"><a href="/dashboard/security">Security</a></li>
  </ul>
</div>
@stop

@section('user-panel')
	<h1 class="page-header">Security</h1>
	{{Form::open(['class'=>'form-horizontal'])}}

		{{-- Old Password --}}
		<div class="form-group">
			{{Form::label('old_password', 'Old Password', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::password('old_password', ['class'=>'form-control'])}}
			</div>
		</div>

		{{-- New Password --}}
		<div class="form-group">
			{{Form::label('password', 'New Password', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::password('password', ['class'=>'form-control'])}}
			</div>
		</div>

		{{-- Confirm New Password --}}
		<div class="form-group">
			{{Form::label('password_confirmation', 'Confirm New Password', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::password('password_confirmation', ['class'=>'form-control'])}}
			</div>
		</div>

		<div class="form-group">
			<span class="col-sm-2"></span>
			<div class="col-sm-4">
				{{Form::submit('Save', ['class'=>'btn btn-primary'])}}
			</div>
		</div>
	{{Form::close()}}

	@if (isset($error))
		<div class="alert alert-danger">{{$error}}</div>
	@endif
	@if (isset($message))
		<div class="alert alert-success">{{$message}}</div>
	@endif

	@if (count($errors->all()))
		<div class="alert alert-danger">
			@foreach ($errors->all() as $error)
				<p>{{$error}}</p>
			@endforeach
		</div>
	@endif

@stop