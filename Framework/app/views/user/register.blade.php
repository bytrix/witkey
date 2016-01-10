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

			<h2 class="form-signin-heading">Registration</h2>

			@if ($errors->first('email'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': registerForm.email.$invalid && !registerForm.email.$pristine, 'has-success': registerForm.email.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
					{{Form::email('email', '', ['placeholder'=>'Email', 'class'=>'form-control', 'ng-valid-email', 'required', 'ng-model'=>'email', 'data-toggle'=>'popover', 'data-container'=>'body', 'data-content'=>'A valid email address'])}}
				</div>
			</div>
			@if ($errors->first('password'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': registerForm.password.$invalid && !registerForm.password.$pristine, 'has-success': registerForm.password.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					{{Form::password('password', ['placeholder'=>'Password (More than 6 chars)', 'class'=>'form-control', 'id'=>'password', 'required', 'ng-minlength'=>'6', 'ng-model'=>'password', 'data-toggle'=>'popover', 'data-container'=>'body', 'data-content'=>'Minimize 6 characters'])}}
				</div>
			</div>

			@if ($errors->first('password_confirmation'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': registerForm.password_confirmation.$invalid && !registerForm.password_confirmation.$pristine, 'has-success': registerForm.password_confirmation.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					{{Form::password('password_confirmation', ['placeholder'=>'Confirm Password', 'class'=>'form-control', 'id'=>'password_confirmation', 'required', 'ng-model'=>'password_confirmation', 'pw-check'=>'password'])}}
				</div>
				{{-- <p ng-show="registerForm.password_confirmation.$error.pwmatch">Don't match!</p> --}}
			</div>

			<div class="form-group">
				{{Form::submit('Register', ['class'=>'btn btn-lg btn-primary btn-block', 'ng-disabled'=>'registerForm.$invalid'])}}
			</div>

			<div class="form-group">
				<a href="login">Register already?</a>
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