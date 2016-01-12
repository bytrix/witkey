@extends('layout.master')

@section('content')
	<div class="container">
		<h1 class="page-header">
			Password Reset
		</h1>
		<form action="{{ action('RemindersController@postReset') }}" method="POST" class="col-md-4">
			<input type="hidden" name="token" value="{{ $token }}">
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Email Address">
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="New Password">
			</div>
			<div class="form-group">
				<input type="password" name="password_confirmation" class="form-control" placeholder="New Password Confirmation">
			</div>
			<div class="form-group">
				<input type="submit" value="Reset Password" class="btn btn-primary">
			</div>
		</form>
	</div>
@stop