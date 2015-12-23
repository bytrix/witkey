@extends('task.publish.master')

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
{{-- 
<pre>
	{{dd(Session::all())}}
</pre>
 --}}
		<div class="form-custom">

			<p>
				<strong>Task Title: </strong>
				<h2>{{{Session::get('title')}}}</h2>
			</p>
			{{-- <p><strong>Reward:</strong> &yen;{{Session::get('amount')}}</p> --}}
			<p>
				<strong>Task description: </strong>
				<br>
				{{{Session::get('detail')}}}
			</p>

				<div class="end-price-bar">
					@if (Session::get('type') == 1)
						<span>Reward:</span>
					@elseif (Session::get('type') == 2)
						<span>Budget:</span>
					@endif
					<strong>&yen;{{{Session::get('amount')}}}</strong>
				</div>

			<div style="clear: both">
				{{HTML::link('task/create/step-2', 'Previous', ['class'=>'btn btn-default'])}}
				{{HTML::link('task/create/postCreate', 'Publish', ['class'=>'btn btn-primary'])}}
			</div>

		</div>
	</div>
@stop
