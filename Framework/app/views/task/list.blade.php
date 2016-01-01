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
</style>
@stop

@section('script')
{{HTML::script(URL::asset('assets/script/moment.js'))}}
@stop

@section('content')
	<div class="container">
		<h2>
			<i class="fa fa-list"></i>
			Task List
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
							<h4 class="list-group-item-heading">
								<span class="label label-success">&yen; {{$task->amount}}</span>
								@if ($task->type == 1)
									<span class="label label-warning">Reward</span>
								@elseif($task->type == 2)
									<span class="label label-danger">Bid</span>
								@endif
								<a href="/task/{{$task->id}}">{{{str_limit($task->title, 45)}}}</a>
							</h4>
							<span class="metadata">
								<a href="/user/{{$task->user->id}}" class="property">
									<i class="fa fa-user"></i> {{{$task->user->username}}}
								</a>
								<span class="property">
									<i class="fa fa-calendar"></i>
									{{explode(' ', $task->created_at)[0]}}
								</span>
							</span>
						</div>

						<div class="item-inline pull-right metadata">
							<h4>
							{{count($task->bidder)}} people participated
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