@extends('user.dashboard.dashboard')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
  	<li class="active"><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/profile">Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/mytask">My Task</a></li>
    <li><a href="/dashboard/certification">Real-name Certification</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
</div>
@stop

@section('user-panel')

	<div class="row clearfix panel-group">
		<h1 class="page-header">Overview</h1>
		<div class="col-md-8">
			<div class="avartar">
				<img src="http://www.qqzhuangban.com/uploadfile/2014/06/1/20140619102309896.jpg" alt="">
			</div>
			<div class="greeting">
				<h1>Morning, {{Auth::user()->username}}!</h1>
				<p>Joined on {{explode(' ', Auth::user()->created_at)[0]}}</p>
			</div>
		</div>
		<div class="col-md-4">
			<p>
				<h2>Credit: {{Auth::user()->credit}}</h2>
			</p>
			<p>
				<h2>Balance: &yen; {{Auth::user()->balance}}</h2>
			</p>
		</div>
	</div>

	<div class="row clearfix panel-group">
		<div class="row clearfix">
			<div class="col-md-12 column">
				<div class="tabbable" id="tabs-613887">
					<ul class="nav nav-tabs">
						<li class="active">
							 <a href="#panel-463291" data-toggle="tab">Task published</a>
						</li>
						<li>
							 <a href="#panel-239884" data-toggle="tab">Task done/doing</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="panel-463291">
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
									<a href="task/new">Publish Now?</a>
								</div>
							@endif
						</div>
						<div class="tab-pane" id="panel-239884">
							@if (count(Task::where('bidder_id', Auth::user()->id)->orderBy('created_at', 'desc')->get()))
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
										@foreach (Task::where('bidder_id', Auth::user()->id)->orderBy('created_at', 'desc')->get() as $task)
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
									No task done or doing recently!
									<br>
									<a href="task/list">Do Now?</a>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop