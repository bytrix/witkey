@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">{{Lang::get('dashboard.task-order')}}</a></li>
    <li><a href="/dashboard/myProfile">{{Lang::get('dashboard.my-profile')}}</a></li>
    <li><a href="/dashboard/changeAvatar">{{Lang::get('dashboard.change-avatar')}}</a></li>
    <li class="active"><a href="/dashboard/taskOrder">{{Lang::get('dashboard.task-order')}}<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/favoriteTask">{{Lang::get('dashboard.favorite-task')}}</a></li>
  	<li><a href="/dashboard/myFriends">{{Lang::get('dashboard.my-friend')}}</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/authentication">{{Lang::get('dashboard.realname-authentication')}}</a></li>
    <li><a href="/dashboard/security">{{Lang::get('dashboard.security')}}</a></li>
  </ul>
</div>
@stop

@section('user-panel')

	@section('header')
	@parent
		{{Lang::get('dashboard.task-order')}}
	@stop
	
	{{-- @if (count(Task::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get())) --}}
	@if (count($orders))
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>{{Lang::get('task.task-id')}}</th>
					<th>{{Lang::get('task.title')}}</th>
					<th>{{Lang::get('task.amount')}}</th>
					<th>{{Lang::get('task.date-published')}}</th>
					<th>{{Lang::get('task.rating')}}</th>
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