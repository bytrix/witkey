@extends('layout.default')

@section('content')

	{{HTML::style('assets/style/signin.css')}}
    <div class="container">

		{{Form::open(['class'=>'form-signin'])}}
		{{Form::token()}}
			<h2 class="form-signin-heading">Please sign in</h2>
			{{Form::text('email', '', ['placeholder'=>'email', 'class'=>'form-control'])}}
			{{Form::password('password', ['placeholder'=>'Password', 'class'=>'form-control'])}}
			<div class="checkbox">
				<label>
					{{Form::checkbox('check', 'remember-me', false)}}
					Remember me
				</label>
			</div>
			{{Form::submit('Sign in', ['class'=>'btn btn-lg btn-primary btn-block'])}}
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