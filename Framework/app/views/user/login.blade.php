@extends('user.master')

@section('script')
@parent
	{{HTML::script(URL::asset('assets/script/angular.js'))}}
	<script type="text/javascript">
		$(function() {
			$('#remember').attr('checked', false);
			var form = $('form');
			$('#remember').click(function() {
				if ($(this).attr('checked') == undefined) {
					$(this).attr('checked', true);
					console.log('checked');
					form.attr('action', 'login?remember=true');
				} else {
					$(this).attr('checked', false);
					console.log('undefined');
					form.attr('action', 'login?remember=false');
				}
			});
		});
	</script>
@stop

@section('content')

	{{HTML::style('assets/style/signin.css')}}
    <div class="container" ng-app>
    	@if (Session::has('login_alert'))
			<div class="alert alert-danger login-alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{-- <a href="javascript:;" class="close" data-dismiss="alert">&times;</a> --}}
				<h4>权限拒绝</h4>
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
		{{Form::open(['url'=>'login?remember=false', 'class'=>'form-signin', 'name'=>'loginForm'])}}
		{{Form::token()}}
			<h2 class="form-signin-heading">{{Lang::get('message.login')}}</h2>

			@if (isset($message) || $errors->get('email'))
			<div class="form-group has-error">
			@else
			<div class="form-group" ng-class="{'has-error': loginForm.phone.$invalid && !loginForm.phone.$pristine, 'has-success': loginForm.phone.$valid}">
			@endif
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
					{{-- {{Form::text('email', '', ['placeholder'=>'Email', 'class'=>'form-control'])}} --}}
					{{-- {{Form::email('email', '', ['placeholder'=>Lang::get('message.email'), 'class'=>'form-control', 'ng-invalid-email', 'required', 'ng-model'=>'email'])}} --}}
					{{ Form::text('phone', '', ['class'=>'form-control', 'placeholder'=>Lang::get('message.phoneNumber'), 'ng-pattern'=>'/^[0-9]{11}$/', 'required', 'ng-model'=>'phone']) }}
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
					{{Form::password('password', ['placeholder'=>Lang::get('message.password'), 'class'=>'form-control', 'required', 'ng-minlength'=>'6', 'ng-model'=>'password'])}}
				</div>
{{-- 				@if ($errors->first('password'))
					<p class="help-block">{{$errors->first('password')}}</p>
				@endif --}}
			</div>
			
			<div class="form-group form-inline">
				<div class="checkbox checkbox-primary">
					{{Form::checkbox('check', 'remember-me', false, ['id'=>"remember"])}}
					<label for="remember">{{Lang::get('message.remember-me')}}</label>
				</div>
				<a href="/password/remind" class="pull-right">{{Lang::get('message.forget-password')}}</a>
			</div>
			
			<div class="form-group">
				{{Form::submit(Lang::get('message.login'), ['id'=>'loginBtn', 'class'=>'btn btn-lg btn-primary btn-block', 'ng-disabled'=>'loginForm.$invalid'])}}
			</div>

			<div class="form-group">
				<a href="register">{{Lang::get('message.register-for-new-account')}}</a>
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