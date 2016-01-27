@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
    <li><a href="/dashboard">{{Lang::get('dashboard.overview')}}</a></li>
    <li><a href="/dashboard/myProfile">{{Lang::get('dashboard.my-profile')}}</a></li>
    <li><a href="/dashboard/changeAvatar">{{Lang::get('dashboard.change-avatar')}}</a></li>
    <li><a href="/dashboard/taskOrder">{{Lang::get('dashboard.task-order')}}</a></li>
    <li><a href="/dashboard/favoriteTask">{{Lang::get('dashboard.favorite-task')}}</a></li>
    <li><a href="/dashboard/myFriends">{{Lang::get('dashboard.my-friend')}}</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
    {{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/authentication">{{Lang::get('dashboard.realname-authentication')}}</a></li>
    <li class="active"><a href="/dashboard/security">{{Lang::get('dashboard.security')}}<span class="sr-only">(current)</span></a></li>
  </ul>
</div>
@stop

@section('user-panel')

	@section('header')
	@parent
		{{Lang::get('dashboard.security')}}
	@stop
	
	{{Form::open(['class'=>'form-horizontal'])}}

		{{-- Old Password --}}
		<div class="form-group">
			{{Form::label('old_password', Lang::get('dashboard.old-password'), ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::password('old_password', ['class'=>'form-control'])}}
			</div>
		</div>

		{{-- New Password --}}
		<div class="form-group">
			{{Form::label('password', Lang::get('dashboard.new-password'), ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::password('password', ['class'=>'form-control'])}}
			</div>
		</div>

		{{-- Confirm New Password --}}
		<div class="form-group">
			{{Form::label('password_confirmation', Lang::get('dashboard.confirm-new-password'), ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::password('password_confirmation', ['class'=>'form-control'])}}
			</div>
		</div>

		<div class="form-group">
			<span class="col-sm-2"></span>
			<div class="col-sm-4">
				{{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary'])}}
			</div>
		</div>
	{{Form::close()}}

	@if (isset($error))
		<div class="col-md-2"></div>
		<div class="alert alert-danger col-md-4">{{$error}}</div>
	@endif
	@if (isset($message))
		<div class="col-md-2"></div>
		<div class="alert alert-success col-md-4">{{$message}}</div>
	@endif

	@if (count($errors->all()))
		<div class="col-md-2"></div>
		<div class="alert alert-danger col-md-4">
			@foreach ($errors->all() as $error)
				<p>{{$error}}</p>
			@endforeach
		</div>
	@endif

@stop