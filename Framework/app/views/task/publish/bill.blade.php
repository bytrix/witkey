@extends('layout.task')

@section('style')
<style>
	.end-price-bar{
		font-size: 20px;
		display: block;
		padding: 10px;
		float: right;
	}
	.end-price-bar strong{
		font-size: 25px;
		padding-left: 12px;
	}
</style>
@stop

@section('content')
	<div class="container">
		<h1 class="page-header">Success</h1>
		<ul class='task-procedure third'>
			<li class="first col-md-4">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div>
	<div class="container">



		<div class="form-custom">

			<p>
				<strong>Task Title: </strong>
				<h2>{{Session::get('title')}}</h2>
			</p>
			{{-- <p><strong>Reward:</strong> &yen;{{Session::get('amount')}}</p> --}}
			<p>
				<strong>Task description: </strong>
				<br>
				{{Session::get('detail')}}
			</p>

			<div class="end-price-bar">
				<span>Reward:</span>
				<strong>&yen;{{Session::get('amount')}}</strong>
			</div>

			<div style="clear: both">
				{{HTML::link('task/new/set-reward', 'Previous', ['class'=>'btn btn-default'])}}
				{{HTML::link('task/new/postTask', 'Publish', ['class'=>'btn btn-primary'])}}
			</div>

		</div>
	</div>
@stop
