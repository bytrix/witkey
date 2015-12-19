@extends('layout.home')

@section('content')

	{{HTML::style('assets/style/signin.css')}}
    <div class="container">
    	@if (Session::has('login_alert'))
			<div class="alert alert-danger login-alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Permission Deny</h4>
				<strong>Warning!</strong>
				{{Session::get('login_alert')}}
			</div>
    	@endif

		@if (isset($message))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Invalid Input</h4>
				{{$message}}
			</div>
		@endif
		
		@if (!empty($errors->all()))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Invalid Input</h4>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			</div>
		@endif

		{{Form::open(['class'=>'form-signin'])}}
		{{Form::token()}}
			<h2 class="form-signin-heading">Please sign in</h2>

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
					{{Form::text('email', '', ['placeholder'=>'Email', 'class'=>'form-control'])}}
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					{{Form::password('password', ['placeholder'=>'Password', 'class'=>'form-control'])}}
				</div>
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
				{{Form::submit('Sign in', ['class'=>'btn btn-lg btn-primary btn-block'])}}
			</div>

			<div class="form-group">
				<a href="register">Register for new account</a>
			</div>
		{{Form::close()}}

{{-- 
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
 --}}
    </div> <!-- /container -->

@endsection