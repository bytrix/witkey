@extends('task.master')

@section('style')
@parent
<style>
.item-inline{
	display: inline-block;
}
.item-inline .avatar-sm{
	float: left;
}
.amount{
	font-size: 16px;
	margin-bottom: 5px;
}
.list-group-item-heading>a{
	color: #000;
}
.cw-task-title{
	font-size: 16px;
	padding-left: 8px;
}
.cw-task-title a{
	color: #111;
	text-decoration: none;
}
.cw-task-title a:hover{
	color: #666;
}

.list-group-item{
	transition: 0.1s;
}
.list-group-item:hover{
	background-color: #fdfdfd;
}
</style>
@stop

@section('script')
{{HTML::script(URL::asset('assets/script/moment.js'))}}
{{HTML::script(URL::asset('assets/script/moment-with-locales.min.js'))}}
@stop

@section('content')
	<div class="container">
		<h2 class="page-header">
			<i class="fa fa-list"></i>
			Task List
			<small class="pull-right school-select-wrap">
				School:
				<div class="dropdown pull-right">
					<a href="javascript:;" class="link school-select" data-toggle="dropdown">{{$mySchool->name}}</a>
					<ul class="dropdown-menu">
						@foreach ($schools as $school)
							<li><a href="/school/{{$school->id}}">{{$school->name}}</a></li>
						@endforeach
					</ul>
				</div>
			</small>
		</h2>
		@if (count($tasks))
			<div class="list-group list-group-lg">
				@foreach ($tasks as $task)

					@if ($task->activeUserFilter() == 'active')

					<div href="/task/{{$task->id}}" class="list-group-item">

						<div class="item-inline">
							<a href="/user/{{$task->user->id}}">
								<img class="avatar-sm" src="{{URL::asset('/avatar/' . $task->user->avatar )}}" data-toggle="tooltip" data-placement="left" title="{{$task->user->username}}">
							</a>
						</div>

						<div class="item-inline">
							<div class="list-group-item-heading">
								<div style="float: left; padding-top: 2px">
									<span class="label label-success">&yen; {{$task->amount}}</span>
									@if ($task->type == 1)
										<span class="label label-warning">Reward</span>
									@elseif($task->type == 2)
										<span class="label label-danger">Bid</span>
									@endif
								</div>
								<span class="cw-task-title" style="display: inline-block; padding-top: 2px;"><a href="/task/{{$task->id}}">{{{$task->title}}}</a></span>
							</div>
							<span class="metadata">
								<a href="/user/{{$task->user->id}}" class="property">
									<i class="fa fa-user"></i> {{{$task->user->username}}}
								</a>
								<span class="property">
									<i class="fa fa-calendar"></i>
									{{-- {{explode(' ', $task->created_at)[0]}} --}}
									<span data-toggle="tooltip" data-placement="right" title="{{$task->created_at}}" id="created_at_{{$task->id}}"></span>
								</span>
								{{-- <p id="test{{$task->id}}"></p> --}}
								<script>
									moment.lang('zh-cn');
									// $('#test{{$task->id}}').html('{{$task->created_at}}');
									$('#created_at_{{$task->id}}').html(moment('{{$task->created_at}}', 'YYYY-MM-DD hh:mm:ss').fromNow());
								</script>
							</span>
						</div>

						<div class="item-inline pull-right metadata" style="width: 100px;">
							<h4>
								@if ($task->winning_commit_id != 0 || $task->winning_quote_id != 0)
									<span data-toggle="tooltip" data-placement="top" title="1 people win bid">1</span>
								@else
									<span data-toggle="tooltip" data-placement="top" title="0 people win bid">0</span>
								@endif
								/
								<span data-toggle="tooltip" data-placement="top" title="{{count($task->bidder)}} people participate">{{count($task->bidder)}}</span>
								<span style="padding-left: 20px;">
									@if ($task->state == 4)
										<i class="text-danger fa fa-clock-o" data-toggle="tooltip" data-placement="right" title="TaskEnd"></i>
									@else
										<i class="text-success fa fa-clock-o" data-toggle="tooltip" data-placement="right" title="Bidding..."></i>
									@endif
								</span>
							</h4>
						</div>
					</div>

					@endif



				@endforeach
			</div>
			{{-- Paginator --}}
			{{$tasks->links()}}
		@else
			<div class="alert alert-danger">No task published ever!</div>
		@endif
	</div>
@stop