@extends('layout.home')

@section('content')

	{{HTML::style('assets/style/signin.css')}}
    <div class="container">

		{{Form::open(['class'=>'form-signin'])}}

			<h2 class="form-signin-heading">Registration</h2>

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

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-key"></i></span>
					{{Form::password('password_confirmation', ['placeholder'=>'Confirm Password', 'class'=>'form-control'])}}
				</div>
			</div>

			<div class="form-group">
				{{Form::submit('Register', ['class'=>'btn btn-lg btn-primary btn-block'])}}
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