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
				{{Lang::get('message.unread-message')}}
			</a>
		</li>
		<li>
			<a href="/message/all">
				<span class="count">{{count($messages)}}</span>
				{{Lang::get('message.all-message')}}
			</a>
		</li>
		<li>
			<a href="/message/sent">
				<span class="count">{{$sentMessages->getTotal()}}</span>
				{{Lang::get('message.sent-message')}}
			</a>
		</li>
	</ul>

	<a href="/message/send" class="send btn btn-success center-block">{{Lang::get('message.post-message')}}</a>
@stop

@section('message-board')
	@if (count($errors))
		<p class="alert alert-danger">
			{{$errors->first()}}
		</p>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">{{Lang::get('message.post-message')}}</h3>
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
							@if (count($friends))
								@foreach ($friends as $friend)
									@if ($_GET && $friend->id == $_GET['friend_id'])
										<option value="{{$friend->id}}" avatar="{{$friend->avatar}}" selected>{{$friend->username}} ({{$friend->email}})</option>
									@else
										<option value="{{$friend->id}}" avatar="{{$friend->avatar}}">{{$friend->username}} ({{$friend->email}})</option>
									@endif
								@endforeach
							@endif
						</select>
					</div>
				</div>


				<div class="form-group">
					{{Form::textarea('message', '', ['class'=>'form-control', 'placeholder'=>Lang::get('message.message')])}}
				</div>
				<div class="form-group">
					{{Form::submit(Lang::get('message.send'), ['class'=>'btn btn-primary'])}}
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
				placeholder: "{{Lang::get('message.send-to-whom')}}"
			});
		});
	</script>
@stop