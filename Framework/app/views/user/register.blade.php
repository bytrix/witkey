@extends('user.master')

@section('script')
@parent
	{{HTML::script(URL::asset('assets/script/angular.js'))}}
	<script>
	$(function () {
		// $('input[data-toggle="popover"]').popover({
		// 	trigger: "focus"
		// })
	})
	</script>
@stop

@section('content')

	{{HTML::style('assets/style/signin.css')}}

    <div class="container" ng-app="cwRegApp">

		{{Form::open(['class'=>'form-signin', 'name'=>'registerForm'])}}

			<h2 class="form-signin-heading">{{Lang::get('message.register')}}</h2>

			@if ($errors->first('email'))
			<!-- <div class="form-group has-error"> -->
			@else
			<!-- <div class="form-group" ng-class="{'has-error': registerForm.email.$invalid && !registerForm.email.$pristine, 'has-success': registerForm.email.$valid}"> -->
			@endif
<!-- 				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
					{{Form::email('email', '', ['placeholder'=>Lang::get('message.phoneNumber'), 'class'=>'form-control', 'ng-valid-email', 'required', 'ng-model'=>'email', 'data-toggle'=>'popover', 'data-container'=>'body', 'data-content'=>'A valid email address'])}}
				</div> -->
			<!-- </div> -->
			
			<!-- phone -->
			@if ($errors->first('email'))
			<div class="form-group has-error">
			@else
			<div class="form-group" id="phone-form-group" ng-class="{'has-error': registerForm.phone.$invalid && !registerForm.phone.$pristine, 'has-success': registerForm.phone.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
					{{ Form::text('phone', '', ['id'=>'phone', 'placeholder'=>Lang::get('message.phoneNumber'), 'class'=>'form-control', 'required', 'ng-model'=>'phone', 'ng-pattern'=>'/^[0-9]{11}$/']) }}
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					{{ Form::text('reg_code', '', ['id'=>'reg_code', 'ng-model'=>'reg_code', 'placeholder'=>'验证码', 'class'=>'form-control', 'required', 'ng-pattern'=>'/^[0-9]{6}$/']) }}
					<span class="input-group-btn">
						<!-- <input type="button" id="reg_code_btn" value="s" class="form-control"></input> -->
						<button class="btn btn-default btn-lg" type="button" id="reg_code_btn" style="border-top-right-radius: 4px; border-bottom-right-radius: 4px; text-shadow: none; color: #666;">获取</button>
						<script type="text/javascript">
							$('#reg_code_btn').click(function() {
								var i = 60;
								var phoneNumber = /^[0-9]{11}$/;
								$('#reg_code').removeAttr('disabled');
								$(this).attr('disabled', 'disabled');
								var timer = setInterval(function() {
									if (i > 0) {
										$('#reg_code_btn').text(i + '秒后重发');
										i--;
									} else {
										$('#reg_code_btn').removeAttr('disabled');
										$('#reg_code_btn').text('获取');
										clearInterval(timer);
									}
								}, 1000);
								// console.log(phoneNumber.test('13358212686'));
								// console.log($('#reg_code').val());
								if (!phoneNumber.test($('#phone').val())) {
									$('#reg_code_btn').removeAttr('disabled');
									$('#reg_code_btn').text('获取');
									$('#phone-form-group').addClass('has-error');
									clearInterval(timer);
									// console.log('true');
								} else {
									var userPhone = $('#phone').val();
									$.ajax({
										// url: "/sms/" + generateCode() + "/13358212686"
									});
									// console.log('code sending to ' + userPhone);
									// console.log('false');
								}
							});
							// function demo() {
							// 	if (i <= 0) {
							// 		$('#reg_code_btn').removeAttr('disabled');
							// 		$('#reg_code_btn').text('获取');
							// 	} else {
							// 		$('#reg_code_btn').text(i + '秒后重发');
							// 		i--;
							// 	}
							// }
							// console.log(parseInt(Math.random()*10));
							function generateCode() {
								var code = '';
								for(var i=0; i<6; i++) {
									var random = Math.random()*10;
									// console.log(random);
									code += parseInt(random);
								}
								return code;
							}
							// console.log(generateCode());
						</script>
					</span>
				</div>
			</div>

			<!-- password -->
			@if ($errors->first('password'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': registerForm.password.$invalid && !registerForm.password.$pristine, 'has-success': registerForm.password.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					{{Form::password('password', ['placeholder'=>Lang::get('message.password') . ' (' . Lang::get('message.min-password', array('min'=>6)) . ')', 'class'=>'form-control', 'id'=>'password', 'required', 'ng-minlength'=>'6', 'ng-model'=>'password', 'data-toggle'=>'popover', 'data-container'=>'body', 'data-content'=>'Minimize 6 characters'])}}
				</div>
			</div>

			@if ($errors->first('password_confirmation'))
			<!-- <div class="form-group has-error"> -->
			@else
			<!-- <div class="form-group" ng-class="{'has-error': registerForm.password_confirmation.$invalid && !registerForm.password_confirmation.$pristine, 'has-success': registerForm.password_confirmation.$valid}"> -->
			@endif
<!-- 				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					{{Form::password('password_confirmation', ['placeholder'=>Lang::get('message.confirm-password'), 'class'=>'form-control', 'id'=>'password_confirmation', 'required', 'ng-model'=>'password_confirmation', 'pw-check'=>'password'])}}
				</div> -->
				{{-- <p ng-show="registerForm.password_confirmation.$error.pwmatch">Don't match!</p> --}}
			<!-- </div> -->

			<div class="form-group">
				{{Form::submit(Lang::get('message.register'), ['class'=>'btn btn-lg btn-primary btn-block', 'ng-disabled'=>'registerForm.$invalid'])}}
			</div>

			<div class="form-group">
				<a href="login">{{Lang::get('message.register-already')}}?</a>
			</div>
		{{Form::close()}}


		<div class="form-signin">
			
			@if (!empty($errors->all()))
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</div>
			@endif

			@if (isset($message))
				<div class="alert alert-danger">
					<li>{{ $message }}</li>
				</div>
			@endif
			
		</div>

    </div> <!-- /container -->

    <script>
    angular.module('cwRegApp', [])
	.directive('pwCheck', [function () {
		return {
			require: 'ngModel',
			link: function (scope, elem, attrs, ctrl) {
				var firstPassword = '#' + attrs.pwCheck;
				elem.add(firstPassword).on('keyup', function () {
					scope.$apply(function () {
						// console.info(elem.val() === $(firstPassword).val());
						ctrl.$setValidity('pwmatch', elem.val() === $(firstPassword).val());
					});
				});
			}
		}
	}])
    </script>

@endsection