@extends('layout.master')

@section('content')
	<div class="container">
		<h1 class="page-header">{{Lang::get('message.forget-password')}}</h1>
		<form action="{{ action('RemindersController@postRemind') }}" method="POST" class="form-horizontal col-md-4">
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="{{ Lang::get('remind.email') }}">
			</div>
			<div class="form-group">
				<input type="submit" value="{{ Lang::get('remind.send') }}" class="btn btn-primary">
			</div>
			<div class="form-group">
				@if (Session::has('error'))
					<div class="alert alert-danger">{{ Session::get('error') }}</div>
				@endif
				@if (Session::has('status'))
					<div class="alert alert-success">{{ Session::get('status') }}</div>
				@endif
			</div>
		</form>
	</div>
@stop