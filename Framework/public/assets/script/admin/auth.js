var UserController = function($scope, $http) {

	$scope.findUserById = function(user_id) {
		// alert(user_id);
		for(var userIndex in $scope.users) {
			if ($scope.users[userIndex].id == user_id) {
				return $scope.users[userIndex];
				// alert($scope.users[userIndex].username);
			}
		}
		return null;
	}

	$http.get('http://localhost:8000/admin/getUsers')
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

	$scope.authTobe = function(user_id) {
		$http.get('http://localhost:8000/admin/postAuthTobe/' + user_id);
		if ($scope.findUserById(user_id).authenticated != 0) {
			$scope.findUserById(user_id).authenticated = 1;
		}
	}
	$scope.authSuccess = function(user_id) {
		$http.get('http://localhost:8000/admin/postAuthSuccess/' + user_id);
		if ($scope.findUserById(user_id).authenticated != 0) {
			$scope.findUserById(user_id).authenticated = 2;
		}
	}
	$scope.authFail = function(user_id) {
		$http.get('http://localhost:8000/admin/postAuthFail/' + user_id);
		if ($scope.findUserById(user_id).authenticated != 0) {
			$scope.findUserById(user_id).authenticated = 3;
		}
	}
}