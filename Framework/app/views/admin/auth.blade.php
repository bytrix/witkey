@extends('admin.master')

@section('script')
{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

@section('content')
<div class="container" ng-app>
	<h1>Authentication Board</h1>



		<table class="table table-striped table-hover table-condensed" ng-controller="UserController">
			<thead>
				<tr>
					<th>Status</th>
					<th>ID</th>
					<th>Username</th>
					<th>Email</th>
					<th>Authenticated</th>
				</tr>
			</thead>
			<tbody>

				<tr ng-repeat="user in users" ng-class="{'success':user.authenticated==2, 'danger':user.authenticated==3, 'warning':user.authenticated==1}">
					<td style="width: 140px;">
						<span class="label label-default" ng-show="user.authenticated==0">Unauthenticated</span>
						<span class="label label-warning" ng-show="user.authenticated==1">Tobe-authenticated</span>
						<span class="label label-success" ng-show="user.authenticated==2">Authenticated</span>
						<span class="label label-danger" ng-show="user.authenticated==3">Authenticate Fail</span>
					</td>
					<th ng-bind="user.id"></th>
					<td ng-bind="user.username"></td>
					<td ng-bind="user.email"></td>
					<td>
						<button ng-disabled="user.authenticated==0" class="btn btn-warning" ng-click="authTobe(user.id)">TOBE-PASS</button>
						<button ng-disabled="user.authenticated==0" class="btn btn-success" ng-click="authSuccess(user.id)">PASS</button>
						<button ng-disabled="user.authenticated==0" class="btn btn-danger" ng-click="authFail(user.id)">NO PASS</button>

					</td>
				</tr>

			</tbody>
		</table>


	<script>
		var UserController = function($scope, $http) {
			$http.get('http://localhost:8000/admin/getAuth')
			.success(function(response) {
				$scope.users = response;
			});

			$scope.authTobe = function(id) {
				$http.get('http://localhost:8000/admin/postAuthTobe/' + id);
				if ($scope.users[id-1].authenticated != 0) {
					$scope.users[id-1].authenticated = 1;
				}
			}
			$scope.authSuccess = function(id) {
				$http.get('http://localhost:8000/admin/postAuthSuccess/' + id);
				if ($scope.users[id-1].authenticated != 0) {
					$scope.users[id-1].authenticated = 2;
				}
			}
			$scope.authFail = function(id) {
				$http.get('http://localhost:8000/admin/postAuthFail/' + id);
				if ($scope.users[id-1].authenticated != 0) {
					$scope.users[id-1].authenticated = 3;
				}
			}
		}
	</script>


</div>
@stop