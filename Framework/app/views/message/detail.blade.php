@extends('message.master')

@section('style')
@parent
	<style>
		.message-task-title{
			margin: 2px 4px;
			border-bottom: 1px dashed #aaa;
			padding-bottom: 1px;
		}
	</style>
@stop

@section('nav')
	{{-- nav --}}
	<ul class="nav nav-pills nav-stacked">
		<li>
			<a href="/message">
				<span class="count">{{$unreadMessages->getTotal()}}</span>
				Unread
			</a>
		</li>
		<li>
			<a href="/message/all">
				<span class="count">{{$messages->getTotal()}}</span>
				All Messages
			</a>
		</li>
	</ul>

	<a href="/message/send" class="send btn btn-success center-block">Post Message</a>
@stop

@section('message-board')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Message</h3>
		</div>
		<div class="panel-body">
			<p class="metadata">
				From <a target="blank" href="/user/{{$message->from_user()->id}}">{{$message->from_user()->username}}</a>
				&bull;
				sent at
				<span id="created_at" data-toggle="tooltip" data-placement="top" title="{{$message->created_at}}"></span>
			</p>
			<script>
				$('#created_at').html(moment("{{$message->created_at}}", "YYYY-MM-DD HH:mm:ss").fromNow());
			</script>
			<hr>
			<p>{{$message->message}}</p>
		</div>
	</div>
@stop