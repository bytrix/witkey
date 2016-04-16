@extends('task.master')

@section('content')
	<div class="container">
		<h1 class="page-header">{{ Lang::get('task.pay-success') }}</h1>

		<div class="narrow">
			

			<p>
				<i class="fa fa-check-circle-o text-success"></i>
				<!-- You have paid <span class="text-danger">&yen;{{$task->amount}}</span> to <strong>{{$commit->user->email}}</strong> successfully! -->
				{{ Lang::get('task.you-have-paid-successfully', array('amount' => $task->amount, 'email' => $commit->user->email)) }}
			</p>
			<a href="/task/{{$task->id}}" class="btn btn-default">
				{{ Lang::get('task.back-to-task') }}
			</a>


		</div>
	</div>
@stop