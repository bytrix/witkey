@extends('task.master')

@section('style')
@parent
	<style type="text/css">
		.container{
			text-align: center;
		}
	</style>
@stop

@section('content')
	<div class="container">
		<h1>任务订单提交成功</h1>

		<div class="narrow">
			
			<a href="/task/{{ $task->id }}" class="btn btn-primary">查看任务</a>

		</div>
	</div>
@stop