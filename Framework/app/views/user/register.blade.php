@extends('layout.home')

@section('script')
@parent
	{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

@section('content')

	{{HTML::style('assets/style/signin.css')}}

    <div class="container" ng-app>

		{{Form::open(['class'=>'form-signin', 'name'=>'registerForm'])}}

			<h2 class="form-signin-heading">Registration</h2>

			@if ($errors->first('email'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': registerForm.email.$invalid && !registerForm.email.$pristine, 'has-success': registerForm.email.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon" style="height: 46px;"><i class="fa fa-envelope-o fa-fw"></i></span>
					{{Form::email('email', '', ['placeholder'=>'Email', 'class'=>'form-control', 'ng-valid-email', 'required', 'ng-model'=>'email'])}}
				</div>
			</div>
			@if ($errors->first('password'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': registerForm.password.$invalid && !registerForm.password.$pristine, 'has-success': registerForm.password.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					{{Form::password('password', ['placeholder'=>'Password', 'class'=>'form-control', 'required', 'ng-minlength'=>'6', 'ng-maxlength'=>'20', 'ng-model'=>'password'])}}
				</div>
			</div>

			@if ($errors->first('password_confirmation'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': registerForm.password_confirmation.$invalid && !registerForm.password_confirmation.$pristine, 'has-success': registerForm.password_confirmation.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					{{Form::password('password_confirmation', ['placeholder'=>'Confirm Password', 'class'=>'form-control', 'required'])}}
				</div>
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

@endsection