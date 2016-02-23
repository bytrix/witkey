@extends('task.master')

@section('content')
	<div class="container">

		<h1 class="page-header">Payment</h1>
		
		<div class="narrow">
		
			<p>
				<strong>Receiving Side:</strong>
				{{$commit->user->email}}
			</p>
			<p>
				<strong>Task title:</strong>
				<span class="cw-task-title">{{$task->title}}</span>
			</p>
			<p>
				<strong>Commit No:</strong>
				{{$commit->uuid}}
			</p>
			<p>
				<strong>Committed at:</strong>
				{{$commit->created_at}}
			</p>
			<p>
				<strong>Payment Amount:</strong>
				&yen;{{$task->amount}}
			</p>
			<p>
				<button class="btn btn-success" onclick='window.location.href="{{$commit->uuid}}/success"'>
					Pay
					<i class="fa fa-check"></i>
				</button>
			</p>



		</div>
	</div>
@stop