@extends('user.master')

@section('style')
	<style>
		.control-text{
			padding-top: 7px;
		}
	</style>
@stop

@section('content')
	<div class="container">
		<div class="page-header">
			<h1>Report User</h1>
		</div>


		<div class="col-md-5">
			{{Form::open(['class'=>'form-horizontal'])}}

				<div class="form-group">
					{{Form::label('id', '', ['class'=>'control-label col-md-6'])}}
					<span class="col-md-6 control-text">{{$user->id}}</span>
				</div>
				
				<div class="form-group">
					{{Form::label('user', '', ['class'=>'control-label col-md-6'])}}
					<div class="col-md-6">
						<img src="/avatar/{{$user->avatar}}" class="avatar-md img-rounded">
						<p style="width: 130px; text-align: center">
							{{$user->username}}
						</p>
					</div>
				</div>

				<div class="form-group">
					{{Form::label('email', '', ['class'=>'control-label col-md-6'])}}
					<span class="col-md-6 control-text">{{$user->email}}</span>
				</div>

			{{Form::close()}}
		</div>

		<div class="col-md-5">
			
			{{Form::open(['class'=>'form-horizontal'])}}
				<div class="form-group">
					{{Form::label('reason', '', ['class'=>'control-label'])}}
				</div>
				<div class="form-group">
					{{Form::textarea('reason', '', ['class'=>'form-control'])}}
				</div>
				<div class="form-group">
					{{Form::submit('Send', ['class'=>'btn btn-primary pull-right'])}}
				</div>
			{{Form::close()}}

		</div>



	</div>
@stop