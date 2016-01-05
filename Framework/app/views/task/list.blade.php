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
{{HTML::script(URL::asset('assets/script/moment-with-locales.min.js'))}}
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
							<h4 class="list-group-item-heading" style="max-width: 820px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap">
								<span class="label label-success">&yen; {{$task->amount}}</span>
								@if ($task->type == 1)
									<span class="label label-warning">Reward</span>
								@elseif($task->type == 2)
									<span class="label label-danger">Bid</span>
								@endif
								<a href="/task/{{$task->id}}">{{{$task->title}}}</a>
							</h4>
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

						<div class="item-inline pull-right metadata" style="width: 200px;">
							<h4>
								@if ($task->winning_commit_id != 0 || $task->winning_quote_id != 0)
									<span data-toggle="tooltip" data-placement="top" title="1 people win bid">1</span>
								@else
									<span data-toggle="tooltip" data-placement="top" title="0 people win bid">0</span>
								@endif
								/
								<span data-toggle="tooltip" data-placement="top" title="{{count($task->bidder)}} people participate">{{count($task->bidder)}}</span>
								|
								@if ($task->state == 4)
									<span class="text-danger">Task End</span>
								@else
									<span class="text-success">In the Bidding</span>
								@endif
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