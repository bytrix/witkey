@extends('admin.master')

@section('script')
{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

@section('style')
@parent
<style>
	body{
		/*font-size: 9px;*/
	}
	table img{
		max-height: 24px;
		max-width: 100px;
	}
</style>
@stop


@section('content')
<div ng-app>

	<ol class="breadcrumb">
		<li><a href="/">Admin</a></li>
		<li class="active">Authentication Board</li>
	</ol>
		<div class="col-md-4"></div>
		<div class="col-md-4">
			{{-- <h1 align="center">Authentication Board</h1> --}}
			<div class="form-group">
				<input ng-model="value" type="search" name="search" value="" placeholder="search" class="form-control">
			</div>
			<p ng-show="value" align="center">Search for @{{value}}</p>
		</div>
		<div class="col-md-4"></div>

		<table class="table table-bordered table-hover table-condensed" ng-controller="UserController">
			<thead>
				<tr>
					<th>Status</th>
					<th>ID</th>
					<th>Realname</th>
					<th>Username</th>
					<th>Email</th>
					<th>Student Card</th>
					<th>School</th>
					<th>Major</th>
					<th>Enrollment Date</th>
					<th>Authentication Operation</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="user in users | filter: value" ng-class="{'success':user.authenticated==2, 'danger':user.authenticated==3, 'warning':user.authenticated==1}">
					<td style="width: 140px;">
						<span class="label label-default" ng-show="user.authenticated==0">Unauthenticated</span>
						<span class="label label-warning" ng-show="user.authenticated==1">Tobe-authenticated</span>
						<span class="label label-success" ng-show="user.authenticated==2">Authenticated</span>
						<span class="label label-danger" ng-show="user.authenticated==3">Authenticate Fail</span>
					</td>
					<td ng-bind="user.id"></td>
					<td>
						<span ng-show="user.realname != null">@{{user.realname}}</span>
						<i class="fa fa-times text-danger" ng-show="user.realname == null"></i>
					</td>
					<td ng-bind="user.username"></td>
					<td ng-bind="user.email"></td>
					<td>
						<a href="/admin/auth/student-card/preview/@{{user.id}}" ng-show="user.student_card != null" target="blank">
							<img src="{{URL::asset('student_card/')}}/@{{user.student_card}}" alt="">
						</a>
						<i class="fa fa-times text-danger" ng-show="user.student_card == null"></i>
					</td>
					<td>
						<span ng-show="user.school != null">
							@{{academies[user.school]}}
							(@{{user.school}})
						</span>
						<i class="fa fa-times text-danger" ng-show="user.school == null"></i>
					</td>
					<td>
						<span ng-show="user.major != null">
							@{{majors[user.major]}}
							(@{{user.major}})
						</span>
						<i class="fa fa-times text-danger" ng-show="user.major == null"></i>
					</td>
					<td>
						<span>@{{user.enrollment_date}}</span>
						<i class="fa fa-times text-danger" ng-show="user.enrollment_date == null"></i>
					</td>
					<td>
						<button ng-disabled="user.authenticated==0" class="btn btn-xs btn-warning" ng-click="authTobe(user.id)"><i class="fa fa-circle-o"></i> To-be pass</button>
						<button ng-disabled="user.authenticated==0" class="btn btn-xs btn-success" ng-click="authSuccess(user.id)"><i class="fa fa-check"></i> Pass</button>
						<button ng-disabled="user.authenticated==0" class="btn btn-xs btn-danger" ng-click="authFail(user.id)"><i class="fa fa-times"></i> No pass</button>
					</td>
				</tr>

			</tbody>
		</table>

	{{HTML::script(URL::asset('assets/script/admin/auth.js'))}}

</div>
@stop