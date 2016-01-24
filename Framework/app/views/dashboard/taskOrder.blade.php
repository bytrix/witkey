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

@section('user-panel')

	@section('header')
	@parent
		Task Order
	@stop
	
	{{-- @if (count(Task::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get())) --}}
	@if (count($orders))
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Amount</th>
					<th>Date</th>
					<th>Rating</th>
				</tr>
			</thead>
			<tbody>
				{{-- @foreach (Task::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get() as $order) --}}
				@foreach ($orders as $order)
				<tr>
					<th>{{$order->id}}</th>
					<td>
						<div class="cw-task-title">
							<a href="/task/{{$order->id}}" target="blank">{{$order->title}}</a>
						</div>
					</td>
					<td>
						@if ($order->amount == NULL)
							&yen; {{$order->amountStart}} ~ {{$order->amountEnd}}
						@else
							&yen; {{$order->amount}}
						@endif
					</td>
					<td>{{$order->created_at}}</td>
					<td>
						@if ($order->state == 4 && $order->winningCommit->comment['id'] == NULL)
							<a href="/dashboard/rate/{{$order->id}}" class="btn btn-success btn-xs">
								<i class="fa fa-star-o"></i>
								Rate
							</a>
						@endif
						@if ($order->winningCommit != NULL && $order->winningCommit->comment['id'] != NULL)
							<span class="text-muted">Evaluated</span>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{$orders->links()}}
	@else
		<div class="alert alert-warning">
			No task published recently!
			<br>
			<a href="/task/create" class="alert-link">Publish Now?</a>
		</div>
	@endif

@stop