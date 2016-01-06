@extends('dashboard.master')

@section('style')
@parent
	{{HTML::style(URL::asset('assets/style/bootstrap-tagsinput.css'))}}
	<style>
		.bootstrap-tagsinput{
			display: block;
		}
	</style>
@stop

@section('script')
	{{HTML::script(URL::asset('assets/script/bootstrap-tagsinput.js'))}}
@stop

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">Overview</a></li>
    <li class="active"><a href="/dashboard/myProfile">My Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/taskOrder">Task Order</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/favoriteTask">Favorite Task</a></li>
    <li><a href="/dashboard/authentication">Real-name Authentication</a></li>
  </ul>
</div>
@stop

@section('user-panel')
<h1 class="page-header">My Profile</h1>

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

	{{-- QQ --}}
	<div class="form-group">
		{{Form::label('qq', 'QQ', ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-qq"></i></span>
				{{Form::text('qq', Auth::user()->qq, ['class'=>'form-control'])}}
			</div>
		</div>
	</div>

	{{-- Dorm --}}
	<div class="form-group">
		{{Form::label('dorm', 'Dorm', ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			{{Form::text(
				'dorm',
				Auth::user()->dorm=='no' ? 'Non-resident' : Auth::user()->dorm,
					[
						'class'=>'form-control',
						'id'=>'dorm',
						Auth::user()->dorm=='no' ? 'disabled' : 'enabled'
					]
			)}}
			{{Form::hidden('dorm_state', '', ['id'=>'dorm_state'])}}
		</div>
		<div class="col-sm-4">
			<div class="checkbox">
				<label>
					{{Form::checkbox('resident', 1, Auth::user()->dorm=='no', ['id'=>'residentCheckbox'])}}
					Non-resident
				</label>
			</div>
			<script>
			$(function() {
				// $('#dorm').attr('enabled', 'enabled');
				$('#residentCheckbox').click(function() {
					if ($('#dorm').attr('enabled') == 'enabled') {
						// Non-resident
						$('#dorm').removeAttr('enabled', 'enabled');
						$('#dorm').attr('disabled', 'disabled');
						$('#dorm').val('Non-resident');
						$('#dorm_state').val('no');
					} else {
						// Resident
						$('#dorm').removeAttr('disabled', 'disabled');
						$('#dorm').attr('enabled', 'enabled');
						$('#dorm').val('');
						$('#dorm_state').val('yes');
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
			{{Form::text('skill_tag', Auth::user()->skill_tag, ['data-role'=>'tagsinput'])}}
		</div>
	</div>

	<div class="form-group">
		<span class="col-sm-2"></span>
		<div class="col-sm-4">{{Form::submit('Save', ['class'=>'btn btn-primary'])}}</div>
	</div>


{{Form::close()}}
@stop