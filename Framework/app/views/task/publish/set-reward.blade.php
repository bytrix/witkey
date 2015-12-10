@extends('layout.task')

@section('content')
	<div class="container">
		<ul class='task-procedure second'>
			<li class="first col-md-4">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div>
	<div class="container">
		<h1>Set your reward</h1>


{{-- 
		<form class="form-inline">
			<div class="form-group">
				<label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
				<div class="input-group">
					<div class="input-group-addon">$</div>
					<input type="text" class="form-control" id="exampleInputAmount" placeholder="Amount">
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Transfer cash</button>
		</form>
 --}}



		{{Form::open(['url'=>'/task/new/bill', 'method'=>'get'])}}
			<div class="input-group">
				<div class="input-group-addon">&yen;</div>
				{{Form::text('amount', '', ['placeholder'=>'Amount', 'class'=>'form-control'])}}
			</div>

			<input class="form-control" type="date" name="date" value="{{date('Y-m-d')}}" placeholder="">

			{{Form::submit('Continue', ['class'=>'btn btn-primary'])}}
		{{Form::close()}}

	</div>
@stop