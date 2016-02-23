@extends('layout.master')

@section('content')
	<div class="container">
		<h1 class="page-header">{{Lang::get('message.forget-password')}}</h1>
		<form action="{{ action('RemindersController@postRemind') }}" method="POST" class="form-horizontal col-md-4">
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Email Address">
			</div>
			<div class="form-group">
				<input type="submit" value="Send Reminder" class="btn btn-primary">
			</div>
		</form>
	</div>
@stop