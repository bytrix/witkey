@extends('layout.task')

@section('content')
	<div class="container">
		<h1 class="page-header">Set your reward</h1>
		<ul class='task-procedure second'>
			<li class="first col-md-4">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div>
	<div class="container">


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



		{{Form::open(['url'=>'/task/new/bill', 'method'=>'post', 'class'=>'form-custom'])}}


			<div class="form-group">
				<div class="radio-inline">
					<label>{{Form::radio('type', '1')}}XS</label>
				</div>
				<div class="radio-inline">
					<label>{{Form::radio('type', '2')}}ZB</label>
				</div>
			</div>

			<div class="form-group">
				{{Form::label('amount', 'Amount:', ['class'=>'control-label'])}}
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-yen"></i>
					</div>
					{{Form::text('amount', Session::get('amount'), ['placeholder'=>'Amount', 'class'=>'form-control'])}}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('date', 'When you wish task to be done:', ['class'=>'control-label'])}}

				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</div>
					<input class="form-control" type="datetime-local" name="expiration" value="{{date('Y-m-d\TH:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d')+7, date('Y')))}}" placeholder="">
				</div>
			</div>

			<div class="form-group">
				<a href="/task/new" class="btn btn-default">Previous</a>
				{{-- <a href="/task/new/bill" class="btn btn-primary">Next</a> --}}
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