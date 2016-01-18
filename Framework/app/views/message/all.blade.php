@extends('message.master')

@section('nav')
	{{-- nav --}}
	<ul class="nav nav-pills nav-stacked">
		<li>
			<a href="/message">
				<span class="count">{{count($unreadMessages)}}</span>
				Unread
			</a>
		</li>
		<li class="active">
			<a href="/message/all">
				<span class="count">{{count($messages)}}</span>
				All Messages
			</a>
		</li>
	</ul>

	<a href="/message/send" class="btn btn-success center-block">Post Message</a>
@stop

@section('message-board')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Messages</h3>
		</div>
		@if (count($messages) == 0)
			<div class="panel-body">
				You have no unread messages
			</div>
		@endif
		<div class="list-group">
			@foreach ($messages as $message)
				@if ($message->read)
					<a href="/message/{{$message->id}}" class="list-group-item">{{$message->message}}</a>
				@else
					<a href="/message/{{$message->id}}" class="list-group-item unread">{{$message->message}}</a>
				@endif
			@endforeach
		</div>
	</div>
@stop