@extends('user.dashboard.dashboard')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
  	<li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/profile">Profile<span class="sr-only">(current)</span></a></li>
    <li class="active"><a href="/dashboard/mytask">My Task</a></li>
    <li><a href="/dashboard/authentication">Real-name Authentication</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
</div>
@stop

@section('user-panel')
	<h1 class="page-header">My Task</h1>
	
	@if (count(Task::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get()))
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
				@foreach (Task::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get() as $task)
				<tr>
					<th>{{$task->id}}</th>
					<td>{{$task->title}}</td>
					<td align="right">&yen; {{$task->amount}}</td>
					<td>{{$task->created_at}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="alert alert-danger">
			No task published recently!
			<br>
			<a href="/task/new" class="alert-link">Publish Now?</a>
		</div>
	@endif

@stop