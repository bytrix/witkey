@extends('task.master')

@section('content')
	<div class="container">

		<h1 class="page-header">{{ Lang::get('task.payment-confirmation') }}</h1>
		
		<div class="narrow">
		
			<p>
				<strong>{{ Lang::get('task.payee') }}:</strong>
				{{$commit->user->email}}
			</p>
			<p>
				<strong>{{ Lang::get('task.title') }}:</strong>
				<span class="cw-task-title">{{$task->title}}</span>
			</p>
			<p>
				<strong>{{ Lang::get('task.commit-no') }}:</strong>
				{{$commit->uuid}}
			</p>
			<p>
				<strong>{{ Lang::get('task.committed-at') }}:</strong>
				{{$commit->created_at}}
			</p>
			<p>
				<strong>{{ Lang::get('task.payment-amount') }}:</strong>
				&yen;{{$task->amount}}
			</p>
			<p>
				<button class="btn btn-success" onclick='window.location.href="{{$commit->uuid}}/success"'>
					{{ Lang::get('task.pay') }}
					<i class="fa fa-check"></i>
				</button>
			</p>



		</div>
	</div>
@stop