@extends('admin.master')

@section('script')
{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

@section('style')
@parent
<style>
	body{
		font-size: 9px;
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
					<th>Registration Date</th>
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
					<th ng-bind="user.id"></th>
					<td ng-bind="user.realname"></td>
					<td ng-bind="user.username"></td>
					<td ng-bind="user.email"></td>
					<td>
						<a href="/student_card/show/@{{user.student_card}}" target="blank">
							<img src="{{URL::asset('student_card/')}}/@{{user.student_card}}" alt="">
						</a>
					</td>
					<td>
						@{{academies[user.school]}}
						(@{{user.school}})
					</td>
					<td>
						@{{majors[user.major]}}
						(@{{user.major}})
					</td>
					<td ng-bind="user.enrollment_date"></td>
					<td ng-bind="user.created_at"></td>
					<td>
						<button ng-disabled="user.authenticated==0" class="btn btn-xs btn-warning" ng-click="authTobe(user.id)"><i class="fa fa-circle-o"></i> TOBE-PASS</button>
						<button ng-disabled="user.authenticated==0" class="btn btn-xs btn-success" ng-click="authSuccess(user.id)"><i class="fa fa-check"></i> PASS</button>
						<button ng-disabled="user.authenticated==0" class="btn btn-xs btn-danger" ng-click="authFail(user.id)"><i class="fa fa-times"></i> NO PASS</button>
					</td>
				</tr>

			</tbody>
		</table>


	<script>
		var UserController = function($scope, $http) {

			$scope.findUserById = function(id) {
				// alert(id);
				for(var userIndex in $scope.users) {
					if ($scope.users[userIndex].id == id) {
						return $scope.users[userIndex];
						// alert($scope.users[userIndex].username);
					}
				}
				return null;
			}

			$http.get('http://localhost:8000/admin/getAuth')
				.success(function(response) {
					$scope.users = response;
				});
			$http.get('http://localhost:8000/config/academy/')
				.success(function(response) {
					$scope.academies = response;
				})
			$http.get('http://localhost:8000/config/major/')
				.success(function(response) {
					$scope.majors = response;
				})

			$scope.authTobe = function(id) {
				$http.get('http://localhost:8000/admin/postAuthTobe/' + id);
				if ($scope.findUserById(id).authenticated != 0) {
					$scope.findUserById(id).authenticated = 1;
				}
			}
			$scope.authSuccess = function(id) {
				$http.get('http://localhost:8000/admin/postAuthSuccess/' + id);
				if ($scope.findUserById(id).authenticated != 0) {
					$scope.findUserById(id).authenticated = 2;
				}
			}
			$scope.authFail = function(id) {
				$http.get('http://localhost:8000/admin/postAuthFail/' + id);
				if ($scope.findUserById(id).authenticated != 0) {
					$scope.findUserById(id).authenticated = 3;
				}
			}
		}
	</script>


</div>
@stop