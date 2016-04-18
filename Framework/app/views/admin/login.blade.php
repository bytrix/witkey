@extends('admin.master')

@section('style')
@parent

	<style type="text/css">
	.form-heading,
	.form-wrap{
		margin: 0 auto;
		width: 300px;
		margin-bottom: 12px;
		text-align: center;
	}
	.form-heading{
	}
	</style>

@stop

@section('content')

	<div class="container">


		<div class="row">
			<div class="col-md-12">
				
				<h1 class="form-heading">口令</h1>

				{{ Form::open(['class'=>'form-wrap']) }}
					<div class="form-group">
						{{ Form::password('password', ['class'=>'form-control']) }}
					</div>

					@if (Session::has('message'))
						<div class="form-group alert alert-danger">
							<span class="close" data-dismiss="alert">&times;</span>
							{{ Session::get('message') }}
						</div>
					@endif

					<div class="form-group">
						{{ Form::submit('Enter', ['class'=>'btn btn-primary']) }}
					</div>
				{{ Form::close() }}

			</div>
		</div>


	</div>

@stop