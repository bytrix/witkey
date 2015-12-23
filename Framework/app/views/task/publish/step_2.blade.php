@extends('task.publish.master')

@section('script')
<script>
	$(function() {
		var hasBudget = true;
		$('#budgetCheckboxDiv').hide();

		function budgetCheckboxToggle() {
			// alert(hasBudget);
			if ($('#budgetCheckbox').attr('checked') == 'checked') {
				hasBudget = false;
				disableAmount();
			} else {
				hasBudget = true;
				enableAmount();
			}
		}


		function changeToReward() {
			$('#moneyType').html('Reward:');
			$('#amount').attr('placeholder', 'Reward');
			$('#budgetCheckboxDiv').hide();
			enableAmount();
		}

		function changeToBid() {
			budgetCheckboxToggle();
			$('#moneyType').html('Budget:');
			$('#amount').attr('placeholder', 'Budget');
			$('#budgetCheckboxDiv').show();
			// alert(hasBudget);
			if (hasBudget) {
				enableAmount();
			} else {
				disableAmount();
			}
		}

		function enableAmount() {
			$('#amount').attr('enabled', true);
			$('#amount').removeAttr('disabled');
		}

		function disableAmount() {
			$('#amount').attr('disabled', true);
			$('#amount').removeAttr('enabled');
		}

		if ($('#reward').attr('checked') == 'checked') {
			changeToReward();
		} else if($('#bid').attr('checked') == 'checked') {
			changeToBid();
		}
		$('#reward').click(function() {
			changeToReward();
		});
		$('#bid').click(function() {
			changeToBid();
		});

		$('#budgetCheckbox').click(function() {
			// budgetCheckboxToggle();
			if ($('#budgetCheckbox').attr('checked') == 'checked') {
				hasBudget = true;
				enableAmount();
				$('#budgetCheckbox').removeAttr('checked');
			} else {
				hasBudget = false;
				disableAmount();
				$('#budgetCheckbox').attr('checked', 'checked');
			}
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
				<div class="checkbox" id="budgetCheckboxDiv">
					<label>
						{{Form::checkbox('hasBudget', '0', false, ['id'=>'budgetCheckbox'])}}
						No budget
					</label>
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