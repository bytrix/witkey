@extends('layout.default')

@section('content')

	{{HTML::style('assets/style/signin.css')}}
    <div class="container">

		{{Form::open(['class'=>'form-signin'])}}

			<h2 class="form-signin-heading">Registration</h2>

			{{Form::text('email', '', ['placeholder'=>'Email', 'class'=>'form-control'])}}

			{{Form::password('password', ['placeholder'=>'Password', 'class'=>'form-control'])}}

			{{Form::password('password_confirmation', ['placeholder'=>'Confirm Password', 'class'=>'form-control'])}}

			{{Form::submit('Register', ['class'=>'btn btn-lg btn-primary btn-block'])}}

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