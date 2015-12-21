@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/myProfile">My Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/taskOrder">Task Order</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/favoriteTask">Favorite Task</a></li>
    <li class="active"><a href="/dashboard/authentication">Real-name Authentication</a></li>
  </ul>
</div>
@stop

@section('user-panel')
	<h1 class="page-header">Authentication</h1>


	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="alert alert-dismissable alert-info">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<strong>Tip:</strong> Your authenticated infomation is secret and we will not expose it to others.
			</div>
		</div>
	</div>


	{{Form::open(['class'=>'form-horizontal', 'enctype'=>'multipart/form-data'])}}

		{{-- Authenticated --}}
		<div class="form-group">
			{{Form::label('authenticated', 'Authenticated', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				@if (Auth::user()->authenticated == 2)
					<div class="label label-success">Authenticated</div>
				@elseif (Auth::user()->authenticated == 1)
					<div class="label label-warning">To-be-authenticated</div>
				@elseif (Auth::user()->authenticated == 0)
					<div class="label label-default">Non-authenticated</div>
				@elseif (Auth::user()->authenticated == 3)
					<div class="label label-danger">Authenticated failure</div>
				@endif
				{{-- {{Form::text('authenticated', Auth::user()->authenticated, ['class'=>'form-control'])}} --}}
			</div>
		</div>

		{{-- Real name --}}
		<div class="form-group">
			{{Form::label('real_name', 'Real Name', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::text('real_name', Auth::user()->real_name, ['class'=>'form-control', Auth::user()->authenticated == 2 ? 'disabled' : ''])}}
			</div>
		</div>

		{{-- School --}}
		<div class="form-group">
			{{Form::label('school', 'School', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
{{-- 				{{Form::text('school', Auth::user()->school, ['class'=>'form-control', Auth::user()->authenticated == 2 ? 'disabled' : ''])}} --}}
				{{Form::select('school', $schoolList, Auth::user()->school, ['class'=>'form-control', Auth::user()->authenticated == 2 ? 'disabled' : ''])}}
			</div>
		</div>


		{{-- Enrollment Date --}}
		<div class="form-group">
			{{Form::label('enrollment_date', 'Enrollment Date', ['class'=>'control-label col-sm-2', ])}}
			<div class="col-sm-4">
				<input type="date" name='enrollment_date' value="{{Auth::user()->enrollment_date}}" placeholder="Enrollment Date" class="form-control"  {{Auth::user()->authenticated == 2 ? 'disabled' : ''}}>
			</div>
		</div>


		{{-- Major --}}
		<div class="form-group">
			{{Form::label('major', 'Major', ['class'=>'control-label col-sm-2'])}}

			@if (Auth::user()->authenticated == 2)
				@if (Auth::user()->major_category == NULL || Auth::user()->major_name == NULL)
					<div class="col-sm-4">
						{{Form::text('major', '未填写', ['class'=>'form-control', 'disabled'])}}
					</div>
				@else
					<div class="col-sm-4">
						{{Form::text('major',
							UserController::$majorCategoryList[Auth::user()->major_category].
								' - '.
								UserController::$majorList[Auth::user()->major_name],
							['class'=>'form-control', 'disabled']
						)}}
					</div>
				@endif
			@else
				<div class="col-sm-4">
					{{Form::select('major_category', $majorCategoryList, Auth::user()->major_category, ['class'=>'form-control', 'multiple', 'size'=>8])}}
				</div>
				<div class="col-sm-4">
					{{Form::select('major_name', $majorList, Auth::user()->major_name, ['class'=>'form-control', 'multiple', 'size'=>8])}}
				</div>
			@endif


		</div>



		@if (Auth::user()->authenticated == 2)
		@else


			{{-- Browse Button --}}
			<div class="form-group">
				{{Form::label('identify_card', 'Identify Card Image', ['class'=>'control-label col-sm-2'])}}
				<div class="col-sm-4">
					{{Form::file('idcard_image', ['class'=>'btn btn-primary'])}}
				</div>
			</div>

			{{-- Identify Card --}}
			<div class="form-group">
				<span class="col-sm-2"></span>
				<div class="col-sm-4">
					@if (Auth::user()->fingerprint)
						{{HTML::image(URL::asset('upload/' . md5(Auth::user()->id . Auth::user()->created_at)), '', ['class'=>'thumbnail idcard_image'])}}
					@else
						{{HTML::image(URL::asset('assets/image/idcard_image.jpg'), '', ['class'=>'thumbnail'])}}
					@endif
					
				</div>
			</div>

			<div class="form-group">
				<span class="col-sm-2"></span>
				<div class="col-sm-4">
					{{Form::submit('Save', ['class'=>'btn btn-primary'])}}
				</div>
			</div>


		@endif







		<script>
		$('input[type=file]').bootstrapFileInput();
		</script>

	{{Form::close()}}

	@if (Session::has('message'))
		<div class="alert alert-success">
			{{Session::get('message')}}
		</div>
	@endif
{{-- 
	@if (Session::has('error'))
		<div class="alert alert-danger">
			{{Session::get('error')}}
		</div>
	@endif
 --}}
	@if (isset($error))
		<div class="alert alert-danger">
			{{$error}}
		</div>
	@endif

	{{-- {{var_dump($errors)}} --}}

	@if (count($errors->all()))
		<div class="alert alert-danger">
			@foreach ($errors->all() as $error)
				<p>{{$error}}</p>
			@endforeach
		</div>
	@endif

@stop