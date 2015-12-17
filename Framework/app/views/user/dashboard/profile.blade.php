@extends('user.dashboard.dashboard')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">Overview</a></li>
    <li class="active"><a href="/dashboard/profile">Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/taskOrder">Task Order</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/taskFollow">Task Follow</a></li>
    <li><a href="/dashboard/authentication">Real-name Authentication</a></li>
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
				<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				{{Form::text('tel', Auth::user()->tel, ['class'=>'form-control'])}}
			</div>
		</div>
	</div>

	{{-- Dorm --}}
	<div class="form-group">
		{{Form::label('dorm', 'Dorm', ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			{{Form::text('dorm', Auth::user()->dorm, ['class'=>'form-control', 'id'=>'dorm'])}}
		</div>
		<div class="col-sm-4">
			<div class="checkbox">
				<label>
					{{Form::checkbox('resident', 1, 1, ['id'=>'residentCheckbox'])}}
					Resident
				</label>
			</div>
			<script>
			$(function() {
				$('#dorm').attr('enabled', 'enabled');
				$('#residentCheckbox').click(function() {
					if ($('#dorm').attr('enabled') == 'enabled') {
						$('#dorm').removeAttr('enabled', 'enabled');
						$('#dorm').attr('disabled', 'disabled');
					} else {
						$('#dorm').removeAttr('disabled', 'disabled');
						$('#dorm').attr('enabled', 'enabled');
					};
				});
			});
			</script>
		</div>
	</div>

	{{-- Skill Tag --}}
	<div class="form-group">
		{{Form::label('skill_tag', 'Skill Tag', ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			{{Form::text('skill_tag', Auth::user()->skill_tag, ['class'=>'form-control'])}}
		</div>
	</div>

	<div class="form-group">
		<span class="col-sm-2"></span>
		<div class="col-sm-4">{{Form::submit('Save', ['class'=>'btn btn-primary'])}}</div>
	</div>


{{Form::close()}}
@stop