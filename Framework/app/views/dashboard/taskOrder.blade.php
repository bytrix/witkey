@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/myProfile">My Profile<span class="sr-only">(current)</span></a></li>
    <li class="active"><a href="/dashboard/taskOrder">Task Order</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/favoriteTask">Favorite Task</a></li>
    <li><a href="/dashboard/authentication">Real-name Authentication</a></li>
  </ul>
</div>
@stop

@section('user-panel')
	<h1 class="page-header">Task Order</h1>
	
	{{-- @if (count(Task::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get())) --}}
	@if (count($orders))
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Amount</th>
					<th>Date</th>
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
					<td align="right">&yen; {{$order->amount}}</td>
					<td>{{$order->created_at}}</td>
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