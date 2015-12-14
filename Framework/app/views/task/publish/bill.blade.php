@extends('layout.task')

@section('content')
	<div class="container">
		<ul class='task-procedure third'>
			<li class="first col-md-4">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div>
	<div class="container">

		<h1 class="page-header">Success</h1>


		<div class="form-custom">

			<p><h2>{{Session::get('title')}}</h2></p>
			<p><strong>Reward:</strong> &yen;{{Session::get('amount')}}</p>
			<p>
				<strong>Task description: </strong>
				<br>
				{{Session::get('detail')}}
			</p>

			{{HTML::link('demand/new/set-reward', 'Previous', ['class'=>'btn btn-default'])}}
			{{HTML::link('demand/new/postDemand', 'Publish', ['class'=>'btn btn-primary'])}}

		</div>
	</div>
@stop
