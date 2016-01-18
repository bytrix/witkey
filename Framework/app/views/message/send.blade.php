@extends('message.master')

@section('script')
@parent
@stop

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
			<h3 class="panel-title">Post Message</h3>
		</div>
		<div class="panel-body">
			{{Form::open()}}


				<div class="row">
{{-- 					<div class="col-md-8 form-group">
						{{Form::text('title', '', ['class'=>'form-control', 'placeholder'=>'Title'])}}
					</div> --}}
					<div class="col-md-12 form-group">
						<select name="friend_id" id="" class="form-control">
							<option></option>
							@foreach ($friends as $friend)
								<option value="{{$friend->id}}" avatar="{{$friend->avatar}}">{{$friend->username}} ({{$friend->email}})</option>
							@endforeach
						</select>
					</div>
				</div>


				<div class="form-group">
					{{Form::textarea('message', '', ['class'=>'form-control', 'placeholder'=>'Message'])}}
				</div>
				<div class="form-group">
					{{Form::submit('Send', ['class'=>'btn btn-primary'])}}
				</div>
			{{Form::close()}}
		</div>
	</div>

	<script>
		$(function() {
			function formatFriend(friend) {
				var avatar = $(friend.element).attr('avatar');
				var text = friend.text;
				// alert(value);
				var a = 1;
				var $friend = $('<img src="/avatar/' + avatar + '" class="cw-xs-img-rounded avatar-xs"><span>' + text + '</span>');
				return $friend;
				// alert(1);
			}
			$('select').select2({
				theme: "bootstrap",
				templateResult: formatFriend,
				placeholder: "Send To"
			});
		});
	</script>
@stop