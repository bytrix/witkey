@extends('task.publish.master')

@section('style')
@parent
	<style>
		.hired_user{
			background-color: red;
		}
		.avatar-60{
			width: 60px;
		}
		#hired_user:hover{
			background-color: #fafafa;
			border-color: #c0c0c0;
		}
		#hired_user .close{
			transition: 0.3s;
		}
	</style>
@stop

@section('script')
{{HTML::script(URL::asset('/assets/script/angular.js'))}}
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
			$('#moneyType').html("{{Lang::get('task.amount-reward')}}");
			// $('#amount').attr('placeholder', 'Reward');
			$('#budgetCheckboxDiv').hide();
			$('#inputReward').show();
			$('#inputBid').hide();
			$('#profitWarning').show();
			enableAmount();
		}

		function changeToBid() {
			budgetCheckboxToggle();
			$('#moneyType').html("{{Lang::get('task.amount-budget')}}");
			// $('#amount').attr('placeholder', 'Budget');
			$('#budgetCheckboxDiv').show();
			$('#inputBid').show();
			$('#inputReward').hide();
			$('#profitWarning').hide();
			// alert(hasBudget);
			if (hasBudget) {
				enableAmount();
			} else {
				disableAmount();
			}
		}

		function enableAmount() {
			// $('#amount').attr('enabled', true);
			// $('#amount').removeAttr('disabled');
			$('#inputBid input').attr('enabled', true);
			$('#inputBid input').removeAttr('disabled');
		}

		function disableAmount() {
			// $('#amount').attr('disabled', true);
			// $('#amount').removeAttr('enabled');
			$('#inputBid input').attr('disabled', true);
			$('#inputBid input').removeAttr('enabled');
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
@parent
{{-- 	<div class="container">
		<h1 class="page-header">
			Set your reward
			
	          <small class="pull-right school-select-wrap">
	            School:
	            <div class="dropdown pull-right">
	              <a href="javascript:;" class="link school-select" data-toggle="dropdown">{{$mySchool->name}}</a>
	              <ul class="dropdown-menu">
					@foreach ($schools as $school)
						<li><a href="/school/{{$school->id}}">
							{{$school->name}}
							@if ($mySchool->id == $school->id)
								<i class="fa fa-check text-success"></i>
							@endif
						</a></li>
					@endforeach
	              </ul>
	            </div>
	          </small>
		</h1>
		<ul class='task-procedure second state'>
			<li class="first second col-md-4">CREATE TASK</li>
			<li class="second col-md-4 light">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div> --}}
	@section('header')
		{{Lang::get('task.set-reward')}}
	@stop

	@section('task-procedure')
		<ul class='task-procedure second state'>
			<li class="first second col-md-4">{{Lang::get('task.create-task')}}</li>
			<li class="second col-md-4 light">{{Lang::get('task.set-reward')}}</li>
			<li class="third col-md-4">{{Lang::get('task.task-publish')}}</li>
		</ul>
	@stop
	<div class="container" ng-app>

		{{Form::open(['url'=>'/task/create/step-3', 'method'=>'post', 'class'=>'form-horizontal', 'ng-controller'=>'profitController', 'autocomplete'=>'off'])}}

			<div class="form-group">
				<div class="col-md-2"></div>
				<div class="col-md-4">
					<div class="radio radio-inline">
						{{Form::radio('type', '1', Session::get('type') == '1', ['id'=>'reward', 'checked'=>'checked'])}}
						<label for="reward">{{Lang::get('task.reward')}}</label>
					</div>
					<div class="radio radio-inline">
						{{Form::radio('type', '2', Session::get('type') == '2', ['id'=>'bid'])}}
						<label for="bid">{{Lang::get('task.bid')}}</label>
					</div>
				</div>
			</div>


			<div class="form-group">
				{{Form::label('expiration', Lang::get('task.when-you-wish-to-finish-task'), ['class'=>'control-label col-md-2'])}}
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar fa-fw"></i>
						</div>
						{{-- {{Form::text('expiration', date( 'Y-m-d H:i', mktime(date('H'), date('i'), date('s'), date('m'), date('d')+7, date('Y')) ), ['class'=>'form-control', 'id'=>'expiration', 'placeholder'=>'Expiration'])}} --}}
						{{Form::text('expiration', Session::get('expiration'), ['class'=>'form-control', 'id'=>'expiration', 'placeholder'=>'0000-00-00 00:00'])}}
						<script>
						$('#expiration').datetimepicker({
							language: 'zh-CN',
							startDate: '2010-01-01'
						});
						</script>
					</div>
				</div>
			</div>

			<div class="form-group">
				{{Form::label('category', Lang::get('category.category'), ['class'=>'control-label col-md-2'])}}
				<div class="col-md-4">
					<select name="category_id" id="" class="form-control">
						<option></option>
						@foreach ($categories as $category)
							@if ($category->id == Session::get('category_id'))
								<option value="{{$category->id}}" selected="selected">{{$category->name}}</option>
							@else
								<option value="{{$category->id}}">{{$category->name}}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group">
				{{Form::label('amount', '', ['class'=>'control-label col-md-2', 'id'=>'moneyType'])}}
				<div class="col-md-4">
					<div class="input-group" id="inputReward">
						<div class="input-group-addon">
							<i class="fa fa-yen fa-fw"></i>
						</div>
						{{Form::text('amount', '', ['placeholder'=>'0.1 ~ 5000', 'class'=>'form-control', 'id'=>'amount', 'ng-model'=>'amount'])}}
					</div>
					<div class="input-group" id="inputBid">
						{{Form::text('amountStart', '', ['placeholder'=>'0.1 ~ 5000', 'class'=>'form-control', 'id'=>'amount'])}}
						<div class="input-group-addon">
							{{Lang::get('message.to')}}
						</div>
						{{Form::text('amountEnd', '', ['placeholder'=>'0.1 ~ 5000', 'class'=>'form-control', 'id'=>'amount'])}}
					</div>
					<div class="checkbox checkbox-primary" id="budgetCheckboxDiv">
						{{Form::checkbox('hasBudget', '0', false, ['id'=>'budgetCheckbox'])}}
						<label for="budgetCheckbox">{{Lang::get('task.no-budget')}}</label>
					</div>
				</div>
			</div>

			<div class="form-group" id="profitWarning">
				<span class="col-md-2"></span>
				<div class="col-md-4">
					<p class="alert alert-danger">
						<i class="fa fa-warning"></i>
						Website charges a @{{profitPercent}}% (&yen; @{{(amount * profitPercent / 100).toFixed(2)}}) profit.
					</p>
				</div>
			</div>

			@if ($hired_user != NULL || Session::has('hire'))
				{{Form::hidden('hire', $hired_user->id)}}
				<div class="form-group" id="hired-user-group">
					{{Form::label('hire', '', ['class'=>'control-label col-md-2'])}}
					<div class="col-md-4">
						<a href="javascript:;" id="hired_user" class="btn btn-default center-block" style="text-align: left; white-space: normal;">
							<span class="close" data-toggle="tooltip" data-placement="top" title="Not hire">&times;</span>
							<div style="float: left; margin-top: 13px;">
								{{HTML::image('/avatar/' . $hired_user->avatar, '', ['class'=>'avatar-60 img-rounded'])}}
							</div>
							<div style="padding-left: 18px; display: inline-block; width: 270px;">
								<p>
									{{$hired_user->username}}
									@if ($hired_user->biography)
										<span style="color: #777">, {{$hired_user->biography}}</span>
									@endif
								</p>
								<p>
									@foreach ($hired_user->tag() as $tag)
										<span class="label label-primary">{{$tag}}</span>
									@endforeach
								</p>
							</div>
						</a>
						<script>
							$('.close').click(function() {
								$('#hired-user-group').fadeOut();
							})
						</script>
					</div>
				</div>
			@endif



			<div class="form-group">
				<div class="col-md-2"></div>
				<div class="col-md-4">
					@if ($hired_user == NULL || !Session::has('hire'))
						<a href="/task/create" class="btn btn-default">
							<i class="fa fa-angle-double-left"></i>
							{{Lang::get('task.previous')}}
						</a>
					@else
						<a href="/task/create?hire={{$hired_user->id}}" class="btn btn-default">
							<i class="fa fa-angle-double-left"></i>
							{{Lang::get('task.previous')}}
						</a>
					@endif
					{{-- <a href="/task/new/bill" class="btn btn-primary">Next</a> --}}
					{{-- {{Form::submit('Next', ['class'=>'btn btn-primary'])}} --}}
					<button type="submit" class="btn btn-primary">
						{{Lang::get('task.next')}}
						<i class="fa fa-angle-double-right"></i>
					</button>
				</div>
			</div>

		{{Form::close()}}


		@if (count($errors->all()))
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-4">
				
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
						<p>{{$error}}</p>
					@endforeach
				</div>

			</div>
		@endif
		</div>
		<script>
			$(function() {
				$('select').select2({
					theme: "bootstrap",
					placeholder: "{{Lang::get('category.select')}}"
				});
			});


			var profitController = function($scope) {
				$scope.profitPercent = 0;
			}
		</script>

	</div>
@stop