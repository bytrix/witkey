@extends('message.master')

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
		<li class="active">
			<a href="/message/sent">
				<span class="count">{{$sentMessages->getTotal()}}</span>
				Sent Messages
			</a>
		</li>
	</ul>

	<a href="/message/send" class="send btn btn-success center-block">Post Message</a>
@stop


@section('message-board')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Sent Messages</h3>
		</div>
		@if (count($sentMessages) == 0)
			<div class="panel-body">
				You have no sent messages
			</div>
		@endif
		<div class="list-group">
			@foreach ($sentMessages as $message)
				<a href="/message/{{$message->id}}" class="list-group-item">
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
	{{$sentMessages->links()}}
@stop