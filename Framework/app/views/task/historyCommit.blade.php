@extends('task.master')

@section('script')
@parent
	{{ HTML::script('assets/script/moment.js') }}
	{{ HTML::script('assets/script/moment-with-locales.min.js') }}
@stop

@section('style')
@parent
	<style type="text/css">
	.first-commit .list-group-item{
		box-shadow: 0 0 24px #eaeaea;
	}
	.history-commit .list-group-item{
		background-color: #fefefe;
	}
	.history-commit{
		padding-left: 20px;
	}
	</style>
@stop

@section('content')

	<div class="container">

		<p>
			<a href="/task/{{ $task_id }}">
				<i class="fa fa-angle-double-left"></i>
				{{ Lang::get('task.back-to-task') }}
			</a>
		</p>
		
		<div class="list-group first-commit">

			<p style="margin-top: 20px;">
				<b style="font-size: 20px;">{{ Lang::get('task.latest-commit') }}</b>
			</p>
			<div class="list-group-item">
				<p class="commit_id">
					{{ Lang::get('task.commit-id') }}：#{{ $commit->id }}
				</p>
				<a href="">
					{{ HTML::image(URL::asset('/avatar/' . $commit->user->avatar), '', ['class'=>'avatar-sm']) }}
				</a>
				<span class="metadata">
					<a href="/">
						<b>{{ $commit->user->username }}</b>
					</a>
					{{ Lang::get('task.committed-at') }}
					<span id="committed_at" data-toggle="tooltip" data-placement="right" title="{{ $commit->created_at }}"></span>
					<script type="text/javascript">
						moment.lang('zh-cn');
						$('#committed_at').html(moment("{{ $commit->created_at }}", "YYYY-MM-DD hh:mm:ss").fromNow());
					</script>
				</span>
				<div id="summary">
					{{ $commit->summary }}
				</div>
			</div>

		</div>

		<p>
			<b>{{ Lang::get('task.history-commit') }}</b>
		</p>

		<div class="list-group history-commit">

			
			@foreach ($historyCommit as $commit)
				<div class="list-group-item">
					<p class="commit_id">
						{{ Lang::get('task.commit-id') }}：#{{ $commit->id }}
					</p>
					<a href="/user/{{ $commit->user->id }}">
						{{ HTML::image(URL::asset('/avatar/' . $commit->user->avatar), '', ['class'=>'avatar-sm']) }}
					</a>
					<span class="metadata">
						<a href="/user/{{ $commit->user->id }}">
							<b>{{ $commit->user->username }}</b>
						</a>
						{{ Lang::get('task.committed-at') }}
						<span id="committed_at_{{ $commit->id }}" data-toggle="tooltip" data-placement="right" title="{{ $commit->created_at }}">
							{{ $commit->created_at }}
						</span>
						<script type="text/javascript">
							moment.lang('zh-cn');
							$('#committed_at_{{ $commit->id }}').html(moment("{{ $commit->created_at }}", "YYYY-MM-DD hh:mm:ss").fromNow());
						</script>
					</span>
					<div id="summary">
						{{ $commit->summary }}
					</div>
				</div>
			@endforeach

		</div>

	</div>

@stop