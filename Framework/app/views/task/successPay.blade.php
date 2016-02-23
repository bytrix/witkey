@extends('task.master')

@section('content')
	<div class="container">
		<h1 class="page-header">Success</h1>

		<div class="narrow">
			

			<p>
				<i class="fa fa-check-circle-o text-success"></i>
				You have paid <span class="text-danger">&yen;{{$task->amount}}</span> to <strong>{{$commit->user->email}}</strong> successfully!
			</p>
			<a href="/task/{{$task->id}}" class="btn btn-default">
				Back
			</a>


		</div>
	</div>
@stop