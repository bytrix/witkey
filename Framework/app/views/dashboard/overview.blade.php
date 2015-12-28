@extends('dashboard.master')

@section('control-panel')




<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li class="active"><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/myProfile">My Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/taskOrder">Task Order</a></li>
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

	<div class="row clearfix panel-group">
		<h1 class="page-header">Overview</h1>



		<div class="row clearfix">
			<div class="col-md-12 column">
{{-- 				<div class="alert alert-dismissable alert-info">
					 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						We use Gravatar as our avatar service, go <a href="https://cn.gravatar.com/" target="blank"><strong>here</strong></a> to register a gravatar account.
				</div> --}}
			</div>
		</div>



		<div class="col-md-8">
			<img style="float: left;" class="avatar-md thumbnail img-rounded" src="{{URL::asset('/avatar/' . Auth::user()->avatar )}}">



			<div class="greeting">
				<h1>{{$greeting}}, <a href="/dashboard/myProfile" data-toggle="tooltip" data-placement="bottom" title="Change Username">{{Auth::user()->username}}</a>!</h1>
				<span>
					{{-- <img src="{{URL::asset('assets/image')}}{{Auth::user()->gender == 'M' ? '/iconfont-genderman.png' : '/iconfont-genderwoman.png' }}"> --}}
					@if (Auth::user()->gender == 'M')
						<i class="fa fa-mars"></i>
					@elseif(Auth::user()->gender == 'F')
						<i class="fa fa-venus"></i>
					@endif
				</span>
				<p>Joined on {{explode(' ', Auth::user()->created_at)[0]}}</p>
				<p>Living in {{Auth::user()->city}}</p>
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
							 <a href="#panel-463291" data-toggle="tab">My Orders</a>
						</li>
						<li>
							 <a href="#panel-239884" data-toggle="tab">Tasks done/doing</a>
						</li>
					</ul>

{{-- 
@foreach (Auth::user()->orders as $order)
	<p>
		{{$order->title}}
		{{$order->created_at}}
	</p>
@endforeach
 --}}

					{{-- Tab: My Orders --}}
					<div class="tab-content">
						<div class="tab-pane active" id="panel-463291">
							{{-- @if (count(Auth::user()->tasks->->orderBy('created_at', 'desc')->get())) --}}
							@if (count(Auth::user()->order->all()))
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
										{{-- @foreach (Auth::user()->orders->orderBy('created_at', 'desc')->get() as $order) --}}
										@foreach (Auth::user()->order()->paginate(10) as $order)
										<tr>
											<th>{{$order->id}}</th>
											<td>
												<a href="/task/{{$order->id}}" target="blank">{{$order->title}}</a>
											</td>
											<td align="right">&yen; {{$order->amount}}</td>
											<td>{{$order->created_at}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								{{-- Paginator --}}
								{{Auth::user()->order()->paginate(1)->links()}}
							@else
								<div class="alert alert-warning">
									No order published recently!
									<br>
									<a href="task/create" class="alert-link">Publish Now?</a>
								</div>
							@endif
						</div>



						{{-- Tab: Tasks --}}
						<div class="tab-pane" id="panel-239884">
							@if (count(Auth::user()->task->all()))
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
										@foreach (Auth::user()->task->all() as $task)
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
								<div class="alert alert-warning">
									No task done or doing recently!
									<br>
									<a href="task/list" class="alert-link">Do Now?</a>
								</div>
							@endif
						</div>




					</div>
				</div>
			</div>
		</div>
	</div>

@stop