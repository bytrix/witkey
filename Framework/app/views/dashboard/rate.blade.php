@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">{{Lang::get('dashboard.overview')}}</a></li>
    <li><a href="/dashboard/myProfile">{{Lang::get('dashboard.my-profile')}}</a></li>
    <li><a href="/dashboard/changeAvatar">{{Lang::get('dashboard.change-avatar')}}</a></li>
    <li class="active"><a href="/dashboard/taskOrder">{{Lang::get('dashboard.task-order')}}<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/favoriteTask">{{Lang::get('dashboard.favorite-task')}}</a></li>
  	<li><a href="/dashboard/myFriends">{{Lang::get('dashboard.my-friend')}}</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/authentication">{{Lang::get('dashboard.truename-authentication')}}</a></li>
    <li><a href="/dashboard/security">{{Lang::get('dashboard.security')}}</a></li>
  </ul>
</div>
@stop

@section('style')
@parent
	<style>
		.rate-info{
			padding-top: 7px;
			/*width: 120px;*/
		}
		.rate-star{
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
		{{ Lang::get('task.comment') }}
	@stop
	<a href="/dashboard/taskOrder">
		<i class="fa fa-angle-double-left"></i>
		{{ Lang::get('task.previous') }}
	</a>
	
	{{Form::open(['class'=>'form-horizontal'])}}
		<div class="form-group">
			{{Form::label('title', Lang::get('task.title'), ['class'=>'control-label col-md-2'])}}
			<span class="col-md-8 rate-info">
				<a href="/task/{{$task->id}}">{{$task->title}}</a>
			</span>
		</div>
		<div class="form-group">
			{{Form::label('winner', Lang::get('task.winner'), ['class'=>'control-label col-md-2'])}}
			<span class="col-md-4 rate-info">
				<a href="/user/{{$winner->id}}" target="_blank">{{$winner->username}}</a>
			</span>
			{{Form::hidden('user_id', $winner->id)}}
		</div>
		<div class="form-group">
			{{Form::label('rate', Lang::get('task.star'), ['class'=>'control-label col-md-2'])}}
			<span class="col-md-4 rate-star">
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
			{{Form::label('content', Lang::get('task.comment-content'), ['class'=>'control-label col-md-2'])}}
			<span class="col-md-4">
				{{Form::textarea('content', '', ['class'=>'form-control content', 'rows'=>5])}}
			</span>
		</div>
		<div class="form-group">
			<span class="col-md-2"></span>
			<span class="col-md-4">
				{{Form::submit(Lang::get('task.comment'), ['class'=>'btn btn-primary'])}}
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