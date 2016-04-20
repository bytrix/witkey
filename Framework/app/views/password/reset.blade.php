@extends('layout.master')

@section('content')
	<div class="container">
		<h1 class="page-header">
			密码重置
		</h1>
		<form action="{{ action('RemindersController@postReset') }}" method="POST" class="col-md-4">
			<input type="hidden" name="token" value="{{ $token }}">
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="电子邮件">
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="新密码">
			</div>
			<div class="form-group">
				<input type="password" name="password_confirmation" class="form-control" placeholder="确认新密码">
			</div>
			<div class="form-group">
				<input type="submit" value="重置" class="btn btn-primary">
			</div>
		</form>
	</div>
@stop