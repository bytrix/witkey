@extends('task.master')

@section('script')
<script>
	$(function() {

		function ChangeToReward() {
			$('#moneyType').html('Reward:');
			$('#amount').attr('placeholder', 'Reward');
		}

		function ChangeToBid() {
			$('#moneyType').html('Budget:');
			$('#amount').attr('placeholder', 'Budget');
		}


		if ($('#reward').attr('checked') == 'checked') {
			ChangeToReward();
		} else if($('#bid').attr('checked') == 'checked') {
			ChangeToBid();
		}
		$('#reward').click(function() {
			ChangeToReward();
		});
		$('#bid').click(function() {
			ChangeToBid();
		});
	});
</script>
@stop

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




		{{Form::open(['url'=>'/task/create/step-3', 'method'=>'post', 'class'=>'form-custom'])}}


			<div class="radio">
				<label class="radio-inline">{{Form::radio('type', '1', Session::get('type') == '1', ['id'=>'reward'])}}悬赏</label>
				<label class="radio-inline">{{Form::radio('type', '2', Session::get('type') == '2', ['id'=>'bid'])}}招标</label>
			</div>

			<div class="form-group">
				{{Form::label('amount', '', ['class'=>'control-label', 'id'=>'moneyType'])}}
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-yen fa-fw"></i>
					</div>
					{{Form::text('amount', Session::get('amount'), ['placeholder'=>'Amount', 'class'=>'form-control', 'id'=>'amount'])}}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('expiration', 'Expiration Date:', ['class'=>'control-label'])}}

				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-calendar fa-fw"></i>
					</div>
					<input class="form-control" type="datetime-local" name="expiration" id="expiration" value="{{date('Y-m-d\TH:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d')+7, date('Y')))}}" placeholder="">
				</div>
			</div>

			<div class="form-group">
				<a href="/task/create" class="btn btn-default">Previous</a>
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