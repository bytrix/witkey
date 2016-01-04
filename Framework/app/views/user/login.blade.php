@extends('layout.home')

@section('script')
@parent
	{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

@section('content')

	{{HTML::style('assets/style/signin.css')}}
    <div class="container" ng-app>
    	@if (Session::has('login_alert'))
			<div class="alert alert-danger login-alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Permission Deny</h4>
				<strong>Warning!</strong>
				{{Session::get('login_alert')}}
			</div>
    	@endif

{{-- 		@if (isset($message))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Invalid Input</h4>
				{{$message}}
			</div>
		@endif --}}
{{-- 		
		@if (!empty($errors->all()))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Invalid Input</h4>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			</div>
		@endif
 --}}
		{{Form::open(['class'=>'form-signin', 'name'=>'loginForm'])}}
		{{Form::token()}}
			<h2 class="form-signin-heading">Please sign in</h2>

			@if (isset($message) || $errors->get('email'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': loginForm.email.$invalid && !loginForm.email.$pristine, 'has-success': loginForm.email.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
					{{-- {{Form::text('email', '', ['placeholder'=>'Email', 'class'=>'form-control'])}} --}}
					{{Form::email('email', '', ['placeholder'=>'Email', 'class'=>'form-control', 'ng-invalid-email', 'required', 'ng-model'=>'email'])}}
				</div>
{{-- 				@if ($errors->first('email'))
					<p class="help-block">{{$errors->first('email')}}</p>
				@endif --}}
			</div>


			@if (isset($message) || $errors->get('password'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': loginForm.password.$invalid && !loginForm.password.$pristine, 'has-success': loginForm.password.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					{{Form::password('password', ['placeholder'=>'Password', 'class'=>'form-control', 'required', 'ng-minlength'=>'6', 'ng-model'=>'password'])}}
				</div>
{{-- 				@if ($errors->first('password'))
					<p class="help-block">{{$errors->first('password')}}</p>
				@endif --}}
			</div>
			
			<div class="form-group form-inline">
				<div class="checkbox">
					<label>
						{{Form::checkbox('check', 'remember-me', false)}}
						Remember me
					</label>
				</div>
				<a href="/" class="pull-right">Forget password</a>
			</div>
			
			<div class="form-group">
				{{Form::submit('Sign in', ['class'=>'btn btn-lg btn-primary btn-block', 'ng-disabled'=>'loginForm.$invalid'])}}
			</div>

			<div class="form-group">
				<a href="register">Register for new account</a>
			</div>
		{{Form::close()}}


		<div class="form-signin">
			@if (isset($message))
				<div class="alert alert-danger">
					{{$message}}
				</div>
			@endif
			
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