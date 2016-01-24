@extends('user.master')

@section('style')
@parent
	<style>
		.rating{
			margin-right: 20px;
			float: right;
			margin-top: 12px;
		}
		.avatar{
			width: 40px;
			display: block;
			float: left;
			margin-right: 20px;
		}
		.content{
			display: inline-block;
			margin-top: 10px;
		}
	</style>
@stop

@section('script')
	{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

@section('content')
	<div class="container" ng-app="cw-app">


		<div class="col-md-8">
			<div class="page-header">
				<h1>User info</h1>
			</div>






			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="tabbable" id="tabs-752296">
						<ul class="nav nav-tabs">
							<li class="active">
								 <a href="#panel-822933" data-toggle="tab">His Task</a>
							</li>
							<li>
								 <a href="#panel-486166" data-toggle="tab">Comments</a>
							</li>
						</ul>
						
						<div class="tab-content">
							<div class="tab-pane active task-chain" id="panel-822933">

								 @if (count($commits))
									 @foreach ($commits as $commit)
									 	{{-- {{$commit->user->username}} --}}
										 	@if ($commit->win)
										 		<li>
											 		<span class="created_at">{{explode(' ', $commit->created_at)[0]}}</span>
											 		won the task
												 	<a href="/task/{{$commit->id}}">{{$commit->task->title}}</a>
												 	<i class="fa fa-flag text-danger" data-toggle="tooltip" data-placement="right" title="contrib+1"></i>
										 		</li>
											 @else
											 	<li>
											 		<span class="created_at">{{explode(' ', $commit->created_at)[0]}}</span>
											 		take part in the task
												 	<a href="/task/{{$commit->id}}">{{$commit->task->title}}</a>
											 	</li>
										 	@endif
									 @endforeach
								 @else
								 	<p class="alert alert-danger">No task done.</p>
								 @endif
								{{-- {{$commits->links()}} --}}

{{-- 
 							@foreach ($commits as $commit)
 								<li>
 									{{$commit->task->title}}
 								</li>
 							@endforeach
 							 --}}
							</div>
							<div class="tab-pane" id="panel-486166">
								@if (count($comments))
									<div class="list-group">
										@foreach ($comments as $comment)
											<div class="list-group-item">

												<span class="rating">
													@for ($i = 0; $i < $comment->star; $i++)
														<i class="fa fa-star-o light"></i>
													@endfor
													@for ($i = 0; $i < (5 - $comment->star); $i++)
														<i class="fa fa-star-o"></i>
													@endfor
												</span>

												<a href="/" class="avatar">
													{{-- {{HTML::image("/avatar/" . User::where('id', $comment->from_whom_id)->first()->avatar, '', ['class'=>'avatar-sm'])}} --}}
													{{HTML::image("/avatar/" . $comment->commenter->avatar, '', ['class'=>'avatar-sm'])}}
													{{-- {{User::where('id', $comment->from_whom_id)->first()->username}} --}}
													{{$comment->commenter->username}}
												</a>
												<div class="content">
													{{$comment->content}}
												</div>
												<p class="metadata" style="padding-top: 10px;">
													<span class="property">{{$comment->created_at}}</span>
												</p>
											</div>
										@endforeach
									</div>
								@endif
							</div>
						</div>

					</div>
				</div>
			</div>





		</div>

		<div class="col-md-4">
			<div class="profile">
				<div>
					<img src="{{URL::asset('/avatar/' . $user->avatar )}}" class="thumbnail avatar-lg">
				</div>
				<h4>
					@if ($user->authenticated == 2)
						<i class="fa fa-credit-card text-primary" data-toggle="tooltip" data-placement="left" title="Authenticated User"></i>
					@endif
					{{$user->username}}

					@if ($user->active == 0)
						<span class="label label-danger">[ Inactive ]</span>
					@endif
					<span>
						{{-- <img src="{{URL::asset('assets/image')}}{{$user->gender == 'M' ? '/iconfont-genderman.png' : '/iconfont-genderwoman.png' }}"> --}}
						@if ($user->gender == 'M')
							<i class="fa fa-mars"></i>
						@elseif($user->gender == 'F')
							<i class="fa fa-venus"></i>
						@endif
					</span>
				</h4>
				<p>{{$user->email}}</p>

{{-- 
				<p>
					@if ($user->authenticated == 0)
						<span class="label label-danger">Not Authenticated</span>
					@endif
				</p>
 --}}
				{{-- <p>Joined on {{explode(' ', $user->created_at)[0]}}</p> --}}


				<p data-toggle="tooltip" title="School" data-placement="left">
					@if ($user->school != NULL)
						<i class="fa fa-map-marker"></i>
						{{Academy::get($user->school)->name}}
					@endif
				</p>

				<p data-toggle="tooltip" title="Major" data-placement="left">
					@if ($user->major != NULL)
						{{Major::get($user->major)->name}}
					@endif
				</p>

				<p data-toggle="tooltip" title="Grade" data-placement="left">
					@if ($user->enrollment_date != NULL)
						{{$grade}}
					@endif
				</p>

				@if (Auth::check() && $user->id != Auth::user()->id)
					<p ng-controller="followController">
						<a href="javascript:;" class="btn btn-default btn-xs" ng-click="unfollow()" ng-show="follower">
							<i class="fa fa-minus"></i>
							Unfollow
						</a>
						<a href="javascript:;" class="btn btn-danger btn-xs" ng-click="follow()" ng-show="!follower">
							<i class="fa fa-plus"></i>
							Follow
						</a>
					</p>
				@endif

				<p>
					@if ($user->authenticated == 2 && $user->id != 1)
						<a href="/task/create?hire={{$user->id}}" class="btn btn-success btn-xs">
							<i class="fa fa-hand-o-right"></i>
							Hire TA
						</a>
					@endif
				</p>
				@if ($user->skill_tag != "")
					
					<div>
						<strong>Skill Tag</strong>
						<div>
							@foreach (explode(',', $user->skill_tag) as $tag)
								<span class="label label-info">{{$tag}}</span>
							@endforeach
						</div>
					</div>

				@endif
			</div>
		</div>

		<script>
			/**
			* cw-app Module
			*
			* Description
			*/
			angular.module('cw-app', []).

			controller('followController', ['$scope', '$http', function($scope, $http){
				$http.get("/api/hasFollower/{{$user->id}}")
				.success(function(response) {
					if (response.length == 1) {
						$scope.follower = true;
					} else {
						$scope.follower = false;
					}
				})
				$scope.follow = function() {
					// alert('follow');
					$http.get("/api/follow/{{$user->id}}");
					$scope.follower = true;
				};
				$scope.unfollow = function() {
					// alert('unfollow');
					$http.get("/api/unfollow/{{$user->id}}")
					$scope.follower = false;
				};
			}]);
		</script>

	</div>
@stop