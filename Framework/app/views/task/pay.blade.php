@extends('task.master')

@section('content')
	<div class="container">
		<h1 class="page-header">Payment</h1>

			<p>
				Receiver: {{$commit->user->username}}
			</p>
			<p>
				{{-- {{$task->title}} --}}
				{{$commit->summary}}
			</p>
			<p>
				&yen;{{$task->amount}}
			</p>
			<p>
				<button class="btn btn-success" onclick="window.location.href='success'">Pay</button>
			</p>

	</div>
@stop