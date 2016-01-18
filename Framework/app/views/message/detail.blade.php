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
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Message</h3>
		</div>
		<div class="panel-body">
			{{$message->message}}
		</div>
	</div>
@stop