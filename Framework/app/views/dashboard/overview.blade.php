@extends('dashboard.master')

@section('style')
@parent
	<style>
		.changeAvatar::before{
			content: '';
			color: #fff;
			text-align: center;
			line-height: 130px;
			width: 130px;
			height: 130px;
			display: block;
			position: absolute;
			background-color: rgba(0, 0, 0, 0);
			transition: 0.2s;
			text-shadow: 0 0 10px #000;
			border-radius: 4px;
		}
		.changeAvatar:hover::before{
			content: "{{Lang::get('dashboard.change-avatar');}}";
			background-color: rgba(0, 0, 0, 0.4);
		}
		.user-possession #hongbao-wrap,
		.user-possession #balance-wrap{
			width: 200px;
			position: relative;
			font-size: 30px;
			/*background-color: blue;*/
			overflow: hidden;
			font-weight: bold;
			height: 60px;
			line-height: 60px;
			display: block;
			text-align: center;
			cursor: pointer;
		}
		.user-possession .separate{
/*			border-bottom-width: 50px;
			border-bottom-color: -webkit-linear-gradient(top,blue,red);
			border-bottom-style: solid;*/
			width: 200px;
			height: 2px;
			display: block;
			/*background-color: radial-gradient(blue,red);*/
			background: radial-gradient(135px,#eee,#fff);
			border-radius: 50%;
			/*background-color: red;*/
		}
		.user-possession #hongbao,
		.user-possession #balance{
			/*border-bottom: 1px solid #ddd;*/
			transition: 0.3s;
		}
		.user-possession #hongbao{
			color: #d00;
		}
		.user-possession #balance{
			margin-top: -60px;
			color: orange;
		}
		.user-possession #hongbao-wrap:hover #hongbao{
			margin-top: -60px;
		}
		.user-possession #balance-wrap:hover #balance{
			margin-top: 0px;
		}
	</style>
@stop

@section('script')
@parent
	<script type="text/javascript">
		$(function() {
			$('#hongbao').mouseover(function() {
				// alert('s');
			});
		});
	</script>
@stop

@section('control-panel')

@if (Auth::user()->random_name == true && Session::get('user_id') != Auth::user()->id)
{{-- @if (true) --}}
	{{Session::set('user_id', Auth::user()->id)}}
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">

			{{Form::open(['url'=>'/dashboard/set-username'])}}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">{{Lang::get('message.think-out-a-username')}}</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						{{Form::text('username', '', ['class'=>'form-control', 'placeholder'=>Lang::get('user.username'), 'autofocus'=>true])}}
					</div>
					@if (count($errors))
						<p class="text-danger">{{$errors->first('username')}}</p>
					@endif
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('message.not-now')}}</button>
				{{-- <button type="button" class="btn btn-primary">Save</button> --}}
				{{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary'])}}
				</div>
			{{Form::close()}}

	    </div>
	  </div>
	</div>
	<script>
		$(function() {
			$('#myModal').modal({
				backdrop: "static"
			});
		});
	</script>
@endif


<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li class="active"><a href="/dashboard">{{Lang::get('dashboard.overview')}}<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/myProfile">{{Lang::get('dashboard.my-profile')}}</a></li>
    <li><a href="/dashboard/changeAvatar">{{Lang::get('dashboard.change-avatar')}}</a></li>
    <li><a href="/dashboard/taskOrder">{{Lang::get('dashboard.task-order')}}</a></li>
    <li><a href="/dashboard/favoriteTask">{{Lang::get('dashboard.favorite-task')}}</a></li>
  	<li><a href="/dashboard/myFriends">{{Lang::get('dashboard.my-friend')}}</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/authentication">{{Lang::get('dashboard.truename-authentication')}}</a></li>
    <li><a href="/dashboard/pay-setting">{{Lang::get('dashboard.pay-setting')}}</a></li>
    <li><a href="/dashboard/security">{{Lang::get('dashboard.security')}}</a></li>
  </ul>
</div>


@stop

@section('user-panel')

	<div class="row clearfix panel-group">

	@section('header')
	@parent
		{{Lang::get('dashboard.overview')}}
	@stop


		@if (empty(Auth::user()->email))
		<div class="row clearfix">
			<div class="col-md-12 column">
 				<div class="alert alert-dismissable alert-danger">
					 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						{{ Lang::get('dashboard.email-is-not-tied-to-your-account') }}
						<a class="alert-link" href="/dashboard/myProfile">立即绑定</a>
				</div>
			</div>
		</div>
		@endif



		<div class="col-md-8">
			<a href="/dashboard/changeAvatar" class="changeAvatar">
				@if (Auth::user()->avatar != "")
					<img style="float: left;" class="avatar-md thumbnail img-rounded" src="{{URL::asset('/avatar/' . Auth::user()->avatar )}}">
				@else
					<img style="float: left;" class="avatar-md thumbnail img-rounded" src="http://ico.ooopic.com/ajax/iconpng/?id=319012.png">
				@endif
			</a>



			<div class="greeting">
				<h3>
					{{$greeting}},
					<a href="/dashboard/myProfile" data-toggle="tooltip" data-placement="bottom" title="{{Lang::get('dashboard.change-username')}}">
						{{Auth::user()->username}}
					</a>!
					@if ( Auth::user()->authenticated == 2 )
						<span class="label label-success">认证用户</span>
					@else
						<span class="label label-default">未认证用户</span>
					@endif
				</h3>
				<span style="margin-right: 10px;">
					{{-- <img src="{{URL::asset('assets/image')}}{{Auth::user()->gender == 'M' ? '/iconfont-genderman.png' : '/iconfont-genderwoman.png' }}"> --}}
					@if (Auth::user()->gender == 'M')
						<i class="fa fa-mars"></i>
					@elseif(Auth::user()->gender == 'F')
						<i class="fa fa-venus"></i>
					@endif
				</span>
				<span>
					@foreach (Auth::user()->getPermission() as $key=>$value)
						@if ($value[2])
							<span class="label label-primary">{{ Lang::get('permission.' . $key) }}</span>
						@endif
					@endforeach
				</span>
				<p class="text-muted" style="margin-top: 10px;">{{Lang::get('user.joined-on', array('date'=>explode(' ', Auth::user()->created_at)[0]))}}</p>
				{{-- <p>Living in {{Auth::user()->city}}</p> --}}
			</div>
		</div>
		<div class="col-md-4 user-possession">
			<div id="hongbao-wrap" data-toggle="tooltip" data-placement="top" title="查看红包">
				<div id="hongbao">
					<!-- <h3>{{Lang::get('dashboard.credit')}}: {{Auth::user()->credit}}</h3> -->
					<div>{{ Lang::get('dashboard.hongbao') }}</div>
					<div>
						0
						<span style="font-size: 18px;">个</span>
					</div>
				</div>
			</div>
			<div class="separate"></div>
			<div id="balance-wrap" data-toggle="tooltip" data-placement="bottom" title="点击充值">
				<div id="balance">
					<div>
						0.00
						<span style="font-size: 18px;">元</span>
					</div>
					{{Lang::get('dashboard.balance')}}
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix panel-group">
		<div class="row clearfix">
			<div class="col-md-12 column">
				<div class="tabbable" id="tabs-613887">
					<ul class="nav nav-tabs">
						<li class="active">
							 <a href="#panel-463291" data-toggle="tab">{{Lang::get('dashboard.my-orders')}}</a>
						</li>
						<li>
							 <a href="#panel-239884" data-toggle="tab">{{Lang::get('dashboard.task-done')}}</a>
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
							@if (count($orders))
								<table class="table table-hover table-striped">
									<thead>
										<tr>
											<th>{{Lang::get('task.task-id')}}</th>
											<th>{{Lang::get('task.title')}}</th>
											<th>{{Lang::get('task.amount')}}</th>
											<th>{{Lang::get('task.date-published')}}</th>
											<th>{{Lang::get('task.state')}}</th>
										</tr>
									</thead>
									<tbody>
										{{-- @foreach (Auth::user()->orders->orderBy('created_at', 'desc')->get() as $order) --}}
										@foreach ($orders as $order)
										<tr>
											<th style="width: 100px;">{{$order->id}}</th>
											<td>
												<!-- <div class="cw-task-title"> -->
													<a href="/task/{{$order->id}}" target="_blank">{{$order->title}}</a>
												<!-- </div> -->
											</td>
											<td style="width: 140px; text-align: right;">&yen; {{$order->amount}}</td>
											<td style="width: 170px;">{{$order->created_at}}</td>
											<td style="width: 120px;">
												@if ($order->state == 0)
													<span class="label label-danger">{{ Lang::get('task.closed') }}</span>
												@elseif ($order->state >= 1 && $order->state <= 3)
													<span class="label label-primary">{{ Lang::get('task.bidding') }}</span>
												@elseif ($order->state == 4)
													<span class="label label-success">{{ Lang::get('task.over') }}</span>
												@elseif ($order->state == 5)
													<span class="label label-default">{{ Lang::get('task.expired') }}</span>
												@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								{{-- Paginator --}}
								{{$orders->links()}}
							@else
								<div class="alert alert-warning">
									{{Lang::get('dashboard.no-order-published')}}
									<br>
									<a href="task/create" class="alert-link">{{Lang::get('dashboard.publish-now')}}</a>
								</div>
							@endif
						</div>

						{{-- Tab: Tasks Done --}}
						<div class="tab-pane" id="panel-239884">
							@if (count(Auth::user()->task->all()))
								<table class="table table-hover table-striped">
									<thead>
										<tr>
											<th>{{Lang::get('task.task-id')}}</th>
											<th>{{Lang::get('task.title')}}</th>
											<th>{{Lang::get('task.amount')}}</th>
											<th>{{Lang::get('task.date-published')}}</th>
										</tr>
									</thead>
									<tbody>
										@foreach (Auth::user()->task->all() as $task)
										<tr>
											<th style="width: 100px;">{{$task->id}}</th>
											<td>
												<a href="/task/{{ $task->id }}" target="_blank">{{$task->title}}</a>
											</td>
											<td style="width: 140px; text-align: right;">&yen; {{$task->amount}}</td>
											<td style="width: 170px;">{{$task->created_at}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							@else
								<div class="alert alert-warning">
									{{Lang::get('dashboard.no-task-done')}}
									<br>
									<a href="task/list" class="alert-link">{{Lang::get('dashboard.do-now')}}</a>
								</div>
							@endif
						</div>




					</div>
				</div>
			</div>
		</div>
	</div>

@stop