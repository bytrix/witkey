@extends('layout.home')

@section('content')

	{{HTML::style('assets/style/signin.css')}}
    <div class="container">

		{{Form::open(['class'=>'form-signin'])}}
		{{Form::token()}}
			<h2 class="form-signin-heading">Please sign in</h2>

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
					{{Form::text('email', '', ['placeholder'=>'Email', 'class'=>'form-control'])}}
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-key"></i></span>
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