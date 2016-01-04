@extends('task.master')

@section('content')
	<div class="container">
		<h1 class="page-header">Payment</h1>
		@if (Session::get('payStatus'))
			<p>
				You have paid &yen;{{$task->amount}} to {{$commit->user->username}} successfully!
			</p>
			<a href="/task/{{$task->id}}" class="btn btn-default">
				Back
			</a>
			{{Session::forget('task_id_session')}}
		@else
			{{Form::open(['method'=>'post', 'url'=>'/pay'])}}
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
				{{Form::submit('Pay', ['class'=>'btn btn-success'])}}
			{{Form::close()}}
		@endif
	</div>
@stop