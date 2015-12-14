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
		<h1 class="page-header">Set your reward</h1>


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



		{{Form::open(['url'=>'/demand/new/bill', 'method'=>'post', 'class'=>'form-custom'])}}

			<div class="form-group">
				{{Form::label('amount', 'Amount:', ['class'=>'control-label'])}}
				<div class="input-group">
					<div class="input-group-addon">&yen;</div>
					{{Form::text('amount', Session::get('amount'), ['placeholder'=>'Amount', 'class'=>'form-control'])}}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('date', 'When you wish task to be done:', ['class'=>'control-label'])}}

				<input class="form-control" type="date" name="expire" value="{{date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+7, date('Y')))}}" placeholder="">
			</div>

			<div class="form-group">
				<a href="/demand/new" class="btn btn-default">Previous</a>
				{{-- <a href="/demand/new/bill" class="btn btn-primary">Next</a> --}}
				{{Form::submit('Next', ['class'=>'btn btn-primary'])}}
				
			</div>

		{{Form::close()}}

		@if (count($errors->all()))
			<div class="alert alert-danger">
				@foreach ($errors->all() as $error)
					<p>{{$error}}</p>
				@endforeach
			</div>
		@endif

	</div>
@stop