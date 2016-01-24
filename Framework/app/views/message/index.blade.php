@extends('message.master')

@section('nav')
	{{-- nav --}}
	<ul class="nav nav-pills nav-stacked">
		<li class="active">
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
		<li>
			<a href="/message/sent">
				<span class="count">{{$sentMessages->getTotal()}}</span>
				Sent Messages
			</a>
		</li>
	</ul>

	<a href="/message/send" class="send btn btn-success center-block">Post Message</a>
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
			@if (count($unreadMessages))
				<a href="/message/read-all" style="position: absolute; top: 10px; right: 30px;">Mark all as read</a>
			@endif
		</div>
		@if (count($unreadMessages) == 0)
			<div class="panel-body">
				You have no unread messages
			</div>
		@endif
		<div class="list-group">
			@foreach ($unreadMessages as $message)
				<a href="/message/{{$message->id}}" class="list-group-item unread">
					{{HTML::image('/avatar/' . $message->from_user()->avatar, '', ['class'=>'avatar-xs', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$message->from_user()->username])}}
					<span class="messageTitle">{{Purifier::clean($message->message, 'messageTitle')}}</span>
					<span class="pull-right" id="created_at_{{$message->id}}" data-toggle="tooltip" data-placement="right" title="{{$message->created_at}}"></span>
				</a>
				<script>
					$('#created_at_{{$message->id}}').html(moment('{{$message->created_at}}', 'YYYY-MM-DD HH:mm:ss').fromNow());
				</script>
			@endforeach
		</div>
	</div>
@stop