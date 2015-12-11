@extends('user.dashboard.dashboard')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
  	<li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/profile">Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/mytask">My Task</a></li>
    <li class="active"><a href="/dashboard/certification">Real-name Certification</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
</div>
@stop

@section('user-panel')
	<h1 class="page-header">Certification</h1>

	{{Form::open(['class'=>'form-horizontal', 'enctype'=>'multipart/form-data'])}}

		{{-- Real name --}}
		<div class="form-group">
			{{Form::label('real_name', 'Real name', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::text('real_name', Auth::user()->real_name, ['class'=>'form-control'])}}
			</div>
		</div>

		{{-- School --}}
		<div class="form-group">
			{{Form::label('school', 'School', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::text('school', Auth::user()->school, ['class'=>'form-control'])}}
			</div>
		</div>

		{{-- Identify Card --}}
		<div class="form-group">
			{{Form::label('identify_card', 'Identify Card Image', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				@if (Auth::user()->identify_card)
					{{HTML::image(URL::asset('upload/' . md5(Auth::user()->id . Auth::user()->created_at)), '', ['class'=>'thumbnail idcard_image'])}}
				@else
					{{HTML::image('https://www.baidu.com/img/baidu_jgylogo3.gif', '', ['class'=>'thumbnail'])}}
				@endif
				{{Form::file('idcard_image', ['class'=>'btn btn-primary'])}}
			</div>
		</div>

		<div class="form-group">
			<span class="col-sm-2"></span>
			<div class="col-sm-4">
				{{Form::submit('Save', ['class'=>'btn btn-primary'])}}
			</div>
		</div>

		<script>
		$('input[type=file]').bootstrapFileInput();
		</script>

	{{Form::close()}}

	@if (Session::has('message'))
		<div class="alert alert-success">
			{{Session::get('message')}}
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