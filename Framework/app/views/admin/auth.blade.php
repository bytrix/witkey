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


<div class="container">
	<ol class="breadcrumb">
		<li><a href="/myadmin">MyAdmin</a></li>

		<li class="dropdown">
			<a href="javascript:;" data-toggle="dropdown" class="active">{{ Lang::get('admin.auth-management') }}</a>
			<ul class="dropdown-menu">
				<li><a href="/myadmin/permission">
					<i class="fa fa-lock"></i>
					{{ Lang::get('admin.permission-management') }}
				</a></li>
				<li><a href="/myadmin/academy">
					<i class="fa fa-university"></i>
					{{ Lang::get('admin.academy-management') }}
					</a></li>
				<li><a href="/myadmin/order">
					<i class="fa fa-cube"></i>
					{{ Lang::get('admin.order-management') }}
				</a></li>
			</ul>
		</li>
		<!-- <li class="active">Authentication Board</li> -->

	</ol>

	<h1>
		<i class="fa fa-user"></i>
		{{ Lang::get('admin.auth-management') }}
	</h1>




		<div class="col-md-4" style="color: #888">
			<strong>用户数:</strong>
			<span>
				{{count(User::all())}}
			</span>
		</div>
		<div class="col-md-4">
			{{-- <h1 align="center">Authentication Board</h1> --}}
			<div class="form-group">
				<input ng-model="value" type="search" name="search" value="" placeholder="Search..." class="form-control">
			</div>
			<p ng-show="value" align="center">Search for @{{value}}</p>
		</div>
		<div class="col-md-4"></div>

</div>


<div class="container">
	



		<table class="table table-bordered table-hover table-condensed" ng-controller="UserController">
			<thead>
				<tr>
					<th>状态</th>
					<th>ID</th>
					<th>实名</th>
					<th>用户名</th>
					<th>电话</th>
					<!-- <th>Email</th> -->
					<th>学生证</th>
					<th>学校</th>
					<th>专业</th>
					<th>入学日期</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="user in users | filter: value" ng-class="{'success':user.authenticated==2, 'danger':user.authenticated==3, 'warning':user.authenticated==1}">
					<td style="width: 140px;">
						<span class="label label-default" ng-show="user.authenticated==0">{{ Lang::get('authentication.non-authenticated') }}</span>
						<span class="label label-warning" ng-show="user.authenticated==1">{{ Lang::get('authentication.to-be-authenticated') }}</span>
						<span class="label label-success" ng-show="user.authenticated==2">{{ Lang::get('authentication.authenticated') }}</span>
						<span class="label label-danger" ng-show="user.authenticated==3">{{ Lang::get('authentication.authentication-failure') }}</span>
					</td>
					<td ng-bind="user.id"></td>
					<td>
						<span ng-show="user.truename != null">@{{user.truename}}</span>
						<i class="fa fa-times text-danger" ng-show="user.truename == null"></i>
					</td>
					<td ng-bind="user.username"></td>
					<td ng-bind="user.tel"></td>
					<!-- <td ng-bind="user.email"></td> -->
					<td>
						<a href="/myadmin/auth/student-card/preview/@{{user.id}}" ng-show="user.student_card != null" target="blank">
							<img src="{{URL::asset('student_card/')}}/@{{user.student_card}}" alt="">
						</a>
						<i class="fa fa-times text-danger" ng-show="user.student_card == null"></i>
					</td>
					<td>
						<span ng-show="user.school != null">
							{{-- @{{academies[user.school].name}} --}}
							@{{findAcademyById(user.school).name}}
							(@{{user.school}})
						</span>
						<i class="fa fa-times text-danger" ng-show="user.school == null"></i>
					</td>
					<td>
						<span ng-show="user.major != null">
							<!-- @{{majors[user.major].name}} -->
							@{{ findMajorById(user.major).name }}
							(@{{user.major}})
						</span>
						<i class="fa fa-times text-danger" ng-show="user.major == null"></i>
					</td>
					<td>
						<span>@{{user.enrollment_date}}</span>
						<i class="fa fa-times text-danger" ng-show="user.enrollment_date == null"></i>
					</td>
					<td>
					{{-- 
						<button ng-disabled="user.authenticated==0" class="btn btn-xs btn-warning" ng-click="authTobe(user.id)"><i class="fa fa-circle-o"></i> To-be pass</button>
						<button ng-disabled="user.authenticated==0" class="btn btn-xs btn-success" ng-click="authSuccess(user.id)"><i class="fa fa-check"></i> Pass</button>
						<button ng-disabled="user.authenticated==0" class="btn btn-xs btn-danger" ng-click="authFail(user.id)"><i class="fa fa-times"></i> No pass</button>
 --}}
						<a href="javascript:;" ng-disabled="user.authenticated==0" class="btn btn-xs btn-warning" ng-click="authTobe(user.id)">
							<i class="fa fa-circle-o"></i>
							<!-- To-be pass -->
						</a>
						<a href="javascript:;" ng-disabled="user.authenticated==0" class="btn btn-xs btn-success" ng-click="authSuccess(user.id)">
							<i class="fa fa-check"></i>
							<!-- Pass -->
						</a>
						<a href="javascript:;" ng-disabled="user.authenticated==0" class="btn btn-xs btn-danger" ng-click="authFail(user.id)">
							<i class="fa fa-times"></i>
							<!-- No pass -->
						</a>
					</td>
				</tr>

			</tbody>
		</table>



</div>


	{{HTML::script(URL::asset('assets/script/admin/auth.js'))}}

</div>
@stop