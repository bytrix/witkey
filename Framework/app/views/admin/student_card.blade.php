@extends('admin.master')

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
		<p>
			{{HTML::image(URL::asset('student_card/' . $user->student_card))}}
		</p>
		<p>
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<a href="/student_card/{{$user->student_card}}" class="btn btn-primary btn-lg">Download Image</a>
			</div>
			<div class="col-md-4"></div>
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
			<strong>Realname:</strong>
			{{$user->realname}}
		</p>
		<p>
			<strong>Email:</strong>
			{{$user->email}}
		</p>
		<p>
			<strong>School:</strong>
			{{Academy::getAcademy($user->school)}}
		</p>
		<p>
			<strong>Major:</strong>
			{{Academy::getMajor($user->major)}}
		</p>
		<p>
			<strong>Enrollment Date:</strong>
			{{$user->enrollment_date}}
		</p>
		<p>
			<a href="/admin/postAuthTobe/{{$user_id}}" class="btn btn-warning">
				<i class="fa fa-circle-o"></i>
				To-be pass
			</a>
			<a href="/admin/postAuthSuccess/{{$user_id}}" class="btn btn-success">
				<i class="fa fa-check"></i>
				Pass
			</a>
			<a href="/admin/postAuthFail/{{$user_id}}" class="btn btn-danger">
				<i class="fa fa-times"></i>
				No pass
			</a>
		</p>
		<p>
			@if ($user->hasUserById($user->id - 1))

				<a href="/admin/auth/student-card/preview/{{$user->id - 1}}">
					<i class="glyphicon glyphicon-menu-left"></i>
					<span>Previous</span>
				</a>
			@else
				No user
			@endif
				<i class="glyphicon glyphicon-option-horizontal"></i>
			@if ($user->hasUserById($user->id + 1))
				<a href="/admin/auth/student-card/preview/{{$user->id + 1}}">
					<span>Next</span>
					<i class="glyphicon glyphicon-menu-right"></i>
				</a>
			@else
				No user
			@endif

		</p>
	</div>

</div>
@stop