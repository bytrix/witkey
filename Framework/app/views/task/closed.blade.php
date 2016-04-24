@extends('task.master')

@section('content')
	<div class="container">
		<div class="alert alert-danger">
			<!-- This task has been closed by administrator -->
			<i class="fa fa-times-circle" style="font-size: 30px;"></i>
			{{ Lang::get('task.this-task-has-been-closed') }}
			，返回
			<a href="javascript:history.back();" class="alert-link">任务列表</a>
		</div>
	</div>
@stop