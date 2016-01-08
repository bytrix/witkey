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

	$http.get('/api/getUsers')
		.success(function(response) {
			$scope.users = response;
		});
	$http.get('/api/academy/getAcademies')
		.success(function(response) {
			$scope.academies = response;
		})
	$http.get('/api/academy/getMajors')
		.success(function(response) {
			$scope.majors = response;
		})

	$scope.findAcademyById = function(academy_id) {
		var myAcademy = {};
		angular.forEach($scope.academies, function(academy) {
			if (academy.id == academy_id) {
				// return academy;
				// alert(academy.name);
				// console.log(academy);
				myAcademy = academy;
			};
		});
		return myAcademy;
	}

	$scope.authTobe = function(user_id) {
		$http.get('/api/postAuthTobe/' + user_id);
		if ($scope.findUserById(user_id).authenticated != 0) {
			$scope.findUserById(user_id).authenticated = 1;
		}
	}
	$scope.authSuccess = function(user_id) {
		$http.get('/api/postAuthSuccess/' + user_id);
		if ($scope.findUserById(user_id).authenticated != 0) {
			$scope.findUserById(user_id).authenticated = 2;
		}
	}
	$scope.authFail = function(user_id) {
		$http.get('/api/postAuthFail/' + user_id);
		if ($scope.findUserById(user_id).authenticated != 0) {
			$scope.findUserById(user_id).authenticated = 3;
		}
	}
}