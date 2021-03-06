@extends('admin.master')

@section('script')
{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

@section('style')
@parent
<style>
	img{
		max-width: 100%;
	}
	.info{
		font-size: 20px;
	}
	.info p{
		padding-top: 12px;
	}
	.center-block {
	  display: block;
	  margin-left: auto;
	  margin-right: auto;
	}

</style>
@stop

@section('content')
<ol class="breadcrumb">
	<li><a href="/">Admin</a></li>
	<li><a href="/admin/auth">Authentication Board</a></li>
	<li class="active">Student Card</li>
</ol>

<div class="container" ng-app ng-controller="UserController">
	<div class="col-md-6">
		<p style="min-height: 350px;">
			@if ($user->student_card)
				{{HTML::image(URL::asset('student_card/' . $user->student_card), '', ['class'=>'center-block'])}}
			@else
				{{-- <span class="glyphicon glyphicon-remove text-danger" style="font-size: 140px;">No Picture</span> --}}
				<i class="fa fa-times text-danger">No Picture</i>
			@endif
		</p>
		<p>
			@if ($user->student_card)
				<a href="/student_card/{{$user->student_card}}" class="btn btn-primary btn-lg center-block">
					<i class="fa fa-download"></i>
					Download Image
				</a>
			@else
				<a class="btn btn-primary btn-lg center-block" disabled>
					<i class="fa fa-download"></i>
					Download Image
				</a>
			@endif
		</p>
	</div>
	<div class="col-md-6 info">
		<p>
			<strong>Status: </strong>
			@if ($user->authenticated == 0)
				<span class="label label-default">Non-authenticated</span>
			@elseif($user->authenticated == 1)
				<span class="label label-warning">To-be Authenticated</span>
			@elseif($user->authenticated == 2)
				<span class="label label-success">Authenticated</span>
			@elseif($user->authenticated == 3)
				<span class="label label-danger">Authentication Fail</span>
			@endif
		</p>
		<p>
			<strong>Truename:</strong>
			@if ($user->truename)
				{{$user->truename}}
			@else
				{{-- <span class="glyphicon glyphicon-remove text-danger"></span> --}}
				<i class="fa fa-times text-danger"></i>
			@endif
		</p>
		<p>
			<strong>Phone:</strong>
			@if ($user->tel)
				{{$user->tel}}
			@else
				<i class="fa fa-times text-danger"></i>
			@endif
		</p>
		<p>
			<strong>Email:</strong>
			@if ($user->email)
				{{$user->email}}
			@else
				<i class="fa fa-times text-danger"></i>
			@endif
		</p>
		<p>
			<strong>School:</strong>
			@if ($user->school)
				{{Academy::get($user->school)->name}}
			@else
				{{-- <span class="glyphicon glyphicon-remove text-danger"></span> --}}
				<i class="fa fa-times text-danger"></i>
			@endif
		</p>
		<p>
			<strong>Major:</strong>
			@if ($user->major)
				{{Major::get($user->major)->name}}
			@else
				{{-- <span class="glyphicon glyphicon-remove text-danger"></span> --}}
				<i class="fa fa-times text-danger"></i>
			@endif
		</p>
		<p>
			<strong>Enrollment Date:</strong>
			@if ($user->enrollment_date)
				{{$user->enrollment_date}}
			@else
				{{-- <span class="glyphicon glyphicon-remove text-danger"></span> --}}
				<i class="fa fa-times text-danger"></i>
			@endif
		</p>
		<p>
			@if ($user->authenticated == 0)
				<a class="btn btn-warning" disabled>
					<i class="fa fa-circle-o"></i>
					To-be pass
				</a>
				<a class="btn btn-success" disabled>
					<i class="fa fa-check"></i>
					Pass
				</a>
				<a class="btn btn-danger" disabled>
					<i class="fa fa-times"></i>
					No pass
				</a>
			@else
				<a href="/api/postAuthTobe/{{$user_id}}" class="btn btn-warning">
					<i class="fa fa-circle-o"></i>
					To-be pass
				</a>
				<a href="/api/postAuthSuccess/{{$user_id}}" class="btn btn-success">
					<i class="fa fa-check"></i>
					Pass
				</a>
				<a href="/api/postAuthFail/{{$user_id}}" class="btn btn-danger">
					<i class="fa fa-times"></i>
					No pass
				</a>
			@endif
		</p>
		<p>
			@if ($user->hasUserById($user->id - 1))

				<a class="btn" href="/admin/auth/student-card/preview/{{$user->id - 1}}">
					{{-- <i class="glyphicon glyphicon-menu-left"></i> --}}
					<i class="fa fa-angle-left"></i>
					<span>Previous</span>
				</a>
			@else
				<a class="btn" disabled="disabled">
					{{-- <i class="glyphicon glyphicon-menu-left"></i> --}}
					<i class="fa fa-angle-left"></i>
					<span>Previous</span>
				</a>
			@endif
				|
			@if ($user->hasUserById($user->id + 1))
				<a class="btn" href="/admin/auth/student-card/preview/{{$user->id + 1}}">
					<span>Next</span>
					{{-- <i class="glyphicon glyphicon-menu-right"></i> --}}
					<i class="fa fa-angle-right"></i>
				</a>
			@else
				<a class="btn" disabled="disabled">
					<span>Next</span>
					{{-- <i class="glyphicon glyphicon-menu-right"></i> --}}
					<i class="fa fa-angle-right"></i>
				</a>
			@endif

		</p>
	</div>
	{{HTML::script(URL::asset('assets/script/admin/auth.js'))}}

</div>
@stop