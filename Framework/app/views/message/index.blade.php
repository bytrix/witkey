@extends('message.master')

@section('nav')
	{{-- nav --}}
	<ul class="nav nav-pills nav-stacked">
		<li class="active">
			<a href="/message">
				<span class="count">{{count($unreadMessages)}}</span>
				Unread
			</a>
		</li>
		<li>
			<a href="/message/all">
				<span class="count">{{count($messages)}}</span>
				All Messages
			</a>
		</li>
	</ul>

	<a href="/message/send" class="btn btn-success center-block">Post Message</a>
@stop

@section('message-board')
	@if (Session::has('success'))
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			{{Session::get('success')}}
		</div>
	@endif
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Unread Messages</h3>
		</div>
		@if (count($unreadMessages) == 0)
			<div class="panel-body">
				You have no unread messages
			</div>
		@endif
		<div class="list-group">
			@foreach ($unreadMessages as $message)
				<a href="/message/{{$message->id}}" class="list-group-item unread">{{$message->message}}</a>
			@endforeach
		</div>
	</div>
@stop