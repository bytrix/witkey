@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/myProfile">My Profile</a></li>
    <li><a href="/dashboard/changeAvatar">Change Avatar</a></li>
    <li class="active"><a href="/dashboard/taskOrder">Task Order<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/favoriteTask">Favorite Task</a></li>
  	<li><a href="/dashboard/myFriends">My Friends</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/authentication">Real-name Authentication</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
</div>
@stop

@section('style')
@parent
	<style>
		.rate-info{
			padding-top: 7px;
			width: 120px;
		}
		.rating{
			/*border: 1px solid #ccc;*/
			/*clear: both;*/
		}
		.rating i{
			float: right;
			cursor: pointer;
			color: #aaa;
		}
		.content{
			resize: none;
		}
	</style>
@stop

@section('script')
@parent
	<script>
	$(function() {
		$('.rating').children('i').mouseover(function() {
			var star = $(this).attr('star');
			$(this).siblings().css({'color': '#aaa', 'text-shadow': 'none'});
			$(this).add($(this).nextAll()).css({'color': 'orange', 'text-shadow': '0 0 3px yellow'});
			$('#star').val(star);
		});
	});
	</script>
@stop

@section('user-panel')

	@section('header')
	@parent
		Rate
	@stop
	<a href="/dashboard/taskOrder">
		<i class="fa fa-angle-double-left"></i>
		back
	</a>
	
	{{Form::open(['class'=>'form-horizontal'])}}
		<div class="form-group">
			{{Form::label('title', 'Task Title', ['class'=>'control-label col-md-2'])}}
			<span class="col-md-4 rate-info">
				<a href="/task/{{$task->id}}">{{$task->title}}</a>
			</span>
		</div>
		<div class="form-group">
			{{Form::label('winner', 'Task Winner', ['class'=>'control-label col-md-2'])}}
			<span class="col-md-4 rate-info">
				<a href="/user/{{$winner->id}}">{{$winner->username}}</a>
			</span>
			{{Form::hidden('user_id', $winner->id)}}
		</div>
		<div class="form-group">
			{{Form::label('rate', 'Rate', ['class'=>'control-label col-md-2'])}}
			<span class="col-md-4 rate-info">
				<div class="rating">
					<i class="fa fa-star-o fa-lg" star=5></i>
					<i class="fa fa-star-o fa-lg" star=4></i>
					<i class="fa fa-star-o fa-lg" star=3></i>
					<i class="fa fa-star-o fa-lg" star=2></i>
					<i class="fa fa-star-o fa-lg" star=1></i>
				</div>
			</span>
			{{Form::hidden('star', 0, ['id'=>'star'])}}
		</div>
		<div class="form-group">
			{{Form::label('content', 'Content', ['class'=>'control-label col-md-2'])}}
			<span class="col-md-4">
				{{Form::textarea('content', '', ['class'=>'form-control content', 'rows'=>5])}}
			</span>
		</div>
		<div class="form-group">
			<span class="col-md-2"></span>
			<span class="col-md-4">
				{{Form::submit('Rate', ['class'=>'btn btn-primary'])}}
			</span>
		</div>
	{{Form::close()}}

	@if ($errors->first('content'))
		<span class="col-md-2"></span>
		<span class="alert alert-danger col-md-4">
			{{$errors->first('content')}}
		</span>
	@endif

@stop