@extends('user.dashboard.dashboard')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
  	<li><a href="/dashboard">Overview</a></li>
    <li class="active"><a href="/dashboard/profile">Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/myDemands">My Task</a></li>
    <li><a href="/dashboard/authentication">Real-name Authentication</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
</div>
@stop

@section('user-panel')
<h1 class="page-header">Profile</h1>

@if (Session::has('message'))
	<div class="alert alert-success">{{Session::get('message')}}</div>
@endif

{{Form::open(['class'=>'form-horizontal'])}}
{{Form::token()}}

	{{-- Username --}}
	<div class="form-group">
		{{Form::label('username', 'Username', ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">{{Form::text('username', Auth::user()->username, ['class'=>'form-control'])}}</div>
	</div>

	{{-- Gender --}}
	<div class="form-group">
		{{Form::label('gender', 'Gender', ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			<label class="radio-inline">
				{{Form::radio('gender', 'M', Auth::user()->gender == 'M' ? true : false)}}Male
			</label>
			<label class="radio-inline">
				{{Form::radio('gender', 'F', Auth::user()->gender == 'F' ? true : false)}}Female
			</label>
		</div>
	</div>

	{{-- Tel --}}
	<div class="form-group">
		{{Form::label('tel', 'Tel', ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			<div class="input-group">
				<span class="input-group-addon"><i class="icon-phone"></i></span>
				{{Form::text('tel', Auth::user()->tel, ['class'=>'form-control'])}}
			</div>
		</div>
	</div>

	{{-- Dorm --}}
	<div class="form-group">
		{{Form::label('dorm', 'Dorm', ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			{{Form::text('dorm', Auth::user()->dorm, ['class'=>'form-control'])}}
		</div>
	</div>

	<div class="form-group">
		<span class="col-sm-2"></span>
		<div class="col-sm-4">{{Form::submit('Save', ['class'=>'btn btn-primary'])}}</div>
	</div>

{{Form::close()}}
@stop