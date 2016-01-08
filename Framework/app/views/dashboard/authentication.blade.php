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

@section('script')
@parent
	{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

@section('user-panel')
	<h1 class="page-header">Authentication</h1>


	@if ( ! ( Session::has('message') || isset($error) || count($errors->all()) ) )
		<div class="row clearfix">
			<div class="col-md-12 column">
				<div class="alert alert-dismissable alert-info">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<strong>Tip:</strong> Your authenticated infomation is secret and we will not expose it to others.
				</div>
			</div>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			{{Session::get('message')}}
		</div>
	@endif
	
	@if (isset($error))
		<div class="alert alert-danger">
			{{$error}}
		</div>
	@endif

	@if (count($errors->all()))
		<div class="alert alert-danger">
			@foreach ($errors->all() as $error)
				<p>{{$error}}</p>
			@endforeach
		</div>
	@endif


	{{Form::open(['class'=>'form-horizontal', 'enctype'=>'multipart/form-data', 'ng-controller'=>'academyController'])}}
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
			{{Form::label('realname', 'Real Name', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{Form::text('realname', Auth::user()->realname, ['class'=>'form-control', Auth::user()->authenticated == 2 ? 'disabled' : ''])}}
			</div>
		</div>

		{{-- School --}}
		<div class="form-group">
			{{Form::label('school', 'School', ['class'=>'control-label col-sm-2'])}}
			<div class="col-sm-4">
				{{-- {{Form::select('school', $schoolList, Auth::user()->school, ['class'=>'form-control', Auth::user()->authenticated == 2 ? 'disabled' : ''])}} --}}
				{{-- {{Form::select('school', $schoolList, Auth::user()->school, ['class'=>'form-control', Auth::user()->authenticated == 2 ? 'disabled' : ''])}} --}}

				@if (Auth::user()->authenticated == 2)
					{{Form::text('school', Academy::get(Auth::user()->school)->name, ['class'=>'form-control', 'disabled'])}}
				@else
					<p class="text-success" ng-show="academy.name">
						<span ng-bind="academy.name"></span>
						<i class="fa fa-check"></i>
					</p>
					<select class="form-control" ng-model="academy" ng-options="academy.name for academy in academyList">
						<option value="">Select Major</option>
					</select>
					<input type="hidden" name="school" value="@{{academy.id}}">
					{{-- <span ng-bind="academy.id"></span> --}}

				@endif

			</div>
		</div>







		{{-- Enrollment Date --}}
		<div class="form-group">
			{{Form::label('enrollment_date', 'Enrollment Date', ['class'=>'control-label col-sm-2', ])}}
			<div class="col-sm-4">
				<input id="enrollment_date" type="text" name='enrollment_date' value="{{Auth::user()->enrollment_date}}" placeholder="Enrollment Date" class="form-control"  {{Auth::user()->authenticated == 2 ? 'disabled' : ''}}>
			</div>
		</div>


		{{-- Major --}}
		<div class="form-group">
			{{Form::label('major', 'Major', ['class'=>'control-label col-sm-2'])}}

			@if (Auth::user()->authenticated == 2)
				@if (Auth::user()->major == NULL)
					<div class="col-sm-4">
						{{Form::text('major', '未填写', ['class'=>'form-control', 'disabled'])}}
					</div>
				@else
					<div class="col-sm-4">
						{{Form::text('major', Major::get(Auth::user()->major)->name, ['class'=>'form-control', 'disabled'])}}
					</div>
				@endif
			@else
{{-- 				<div class="col-sm-4">
					{{Form::select('major_category', $majorCategoryList, Auth::user()->major_category, ['class'=>'form-control', 'multiple', 'size'=>8])}}
				</div> --}}
				<div class="col-sm-4">
					{{-- {{Form::select('major', $majorList, Auth::user()->major, ['class'=>'form-control', 'size'=>8])}} --}}
					<p class="text-success" ng-show="academy.name && major.name">
						<span ng-bind="major.name"></span>
						<i class="fa fa-check"></i>
					</p>
					<select name="major" ng-model="major" ng-options="major.name for major in majorList | academyFilter: academy.id" class="form-control">
						<option value="">Select Major</option>
					</select>
					<input type="hidden" name="major" value="@{{major.id}}">
					{{-- <span ng-bind="major.name"></span> --}}
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
					@if (Auth::user()->student_card)
						{{HTML::image(URL::asset('student_card/' . md5('student_card' . Auth::user()->id . Auth::user()->created_at)), '', ['class'=>'thumbnail idcard_image'])}}
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

			$(function() {
				$('input[type=file]').bootstrapFileInput();
				$('select').select2();
				$('#enrollment_date').datepicker({
					language: 'zh-CN',
					format: 'yyyy-mm-dd',
					startDate: '2003-01-01',
					startView: 2
				});
			});

			angular.module('academyApp', [])

			.filter('academyFilter', function(){
				return function(data, academy_id){
					var majors = [];
					angular.forEach(data, function(major){
						if (major.academy_id == academy_id) {
							majors.push(major);
						};
					});
					return majors;
				}
			})

			.controller('academyController', ['$scope', '$http', function($scope, $http){

				// $scope.academy = {};


				$scope.findAcademyById = function(academy_id) {
					var myAcademy = {};
					angular.forEach($scope.academyList, function(academy) {
						if (academy.id == academy_id) {
							// return academy;
							// alert(academy.name);
							// console.log(academy);
							myAcademy = academy;
						};
					});
					return myAcademy;
					// alert(myAcademy.name);
				}

				$scope.findMajorById = function(major_id) {
					var myMajor = {};
					angular.forEach($scope.majorList, function(major) {
						if (major.id == major_id) {
							myMajor = major;
						};
					});
					return myMajor;
				}



				$http.get('/api/authUser')
					.success(function(response) {
						$scope.authUser = response;
					});

				$http.get('/api/academy/getAcademies')
					.success(function(response){
						$scope.academyList = response;
						// $scope.academy = $scope.academyList[1];
						$scope.academy = $scope.findAcademyById($scope.authUser.school);
						// console.log($scope.academy);
						// alert($scope.authUser.school);
					});

				$http.get('/api/academy/getMajors')
					.success(function(response){
						$scope.majorList = response;
						$scope.major = $scope.findMajorById($scope.authUser.major);
						// alert($scope.major.name);
					});

				// $scope.academyList = 
				// [
				//     {
				//         "id": "1",
				//         "created_at": "2016-01-07 17:06:20",
				//         "updated_at": "2016-01-07 17:06:20",
				//         "name": "福州大学至诚学院"
				//     },
				//     {
				//         "id": "2",
				//         "created_at": "2016-01-07 17:16:45",
				//         "updated_at": "2016-01-07 17:16:45",
				//         "name": "福建师范大学"
				//     },
				//     {
				//         "id": "3",
				//         "created_at": "2016-01-07 17:17:10",
				//         "updated_at": "2016-01-07 17:17:10",
				//         "name": "福建江夏学院"
				//     }
				// ];

				// $scope.academy = $scope.academyList[1];



				$scope.users = [
					{
						name: 'jack',
						age: 21
					},
					{
						name: 'tom',
						age: 20
					}
				];

				$scope.myAcademy = {
					name: 'FZU'
				}


			}]);

		</script>
	{{Form::close()}}


@stop