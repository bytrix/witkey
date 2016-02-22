@extends('task.master')

@section('style')
@parent
<style>
.item-inline{
	display: inline-block;
}
.item-inline .avatar-sm{
	float: left;
	margin-bottom: -2px;
}
.amount{
	font-size: 16px;
	margin-bottom: 5px;
}
.list-group-item-heading>a{
	color: #000;
}
.cw-task-title{
	font-size: 16px;
	padding-left: 8px;
	max-width: 700px;
}
.cw-task-title a{
	color: #111;
	text-decoration: none;
}
.cw-task-title a:hover{
	color: #666;
}

.list-group-item{
	transition: 0.15s;
}
.list-group-item:hover{
	background-color: #fcfcfc;
}
.task-state{
	font-size: 14px;
	margin-left: 4px;
}
.category-area{
	margin-bottom: 20px;
}
.category-area .nav>li>a{
	padding: 4px 22px;
}
.category-area .category-name{
	height: 28px;
	line-height: 28px;
	color: #888;
}
.sort-option{
	margin-top: 18px;
}
.sort-option>li{
	margin: 0px 12px;
	float: left;
	list-style-type: none;
}
h1{
	margin: 0px;
}
.btn{
	text-shadow: none;
}
.text-color-888{
	color: #888;
}
.sort-active,
.sort-active:focus,
.sort-active:hover,
.sort-option .open a:focus{
	color: #337ab7;
	text-decoration: none;
}
</style>
@stop

@section('script')
@parent
{{HTML::script(URL::asset('assets/script/moment.js'))}}
{{HTML::script(URL::asset('assets/script/moment-with-locales.min.js'))}}
{{HTML::script(URL::asset('assets/script/angular.js'))}}
<script>
	$(function() {

		function goSearch() {
			var kw = $('#search').val();
			if (kw != "") {
				window.location.href = "/school/{{$mySchool->id}}/search/" + kw;
			}
		}

		$('#search-btn').click(function() {
			goSearch();
		});

		$('#search').keydown(function() {
			if (event.keyCode == 13) {
				goSearch();
			};
		});

	});
</script>
@stop

@section('content')
	<div class="container">


	<div class="page-header">
		<div class="row">
			<div class="col-md-3">
				<h1>
					<i class="fa fa-list"></i>
					{{Lang::get('task.list')}}
				</h1>
			</div>
			<div class="col-md-3"></div>
			<div class="col-md-3">
				<div class="input-group">
					@if (isset($keyword))
						<input type="search" name="search" value="{{$keyword}}" id="search" placeholder="{{Lang::get('message.search')}}" class="form-control">
					@else
						<input type="search" name="search" value="" id="search" placeholder="{{Lang::get('message.search')}}" class="form-control">
					@endif
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default" id="search-btn">
							<i class="fa fa-search text-color-888"></i>
						</button>
					</span>
				</div>


			</div>
			<div class="col-md-3">

            @if ($mySchool != NULL)
              <small class="pull-right school-select-wrap">
                {{Lang::get('message.school')}}:
                <div class="dropdown pull-right">
                  <a href="javascript:;" class="link school-select" data-toggle="dropdown">
                  	{{$mySchool->name}}
                  </a>
                  <ul class="dropdown-menu">
                    @foreach ($schools as $school)
                      <li><a href="/school/{{$school->id}}">
                        {{$school->name}}
                        @if ($mySchool->id == $school->id)
                          <i class="fa fa-check text-success"></i>
                        @endif
                      </a></li>
                    @endforeach
                  </ul>
                </div>
              </small>
            @else
              <small class="pull-right school-select-wrap">
                School:
                <div class="dropdown pull-right">
                  <a href="javascript:;" class="link school-select" data-toggle="dropdown">Select School</a>
                  <ul class="dropdown-menu">
                    @foreach ($schools as $school)
                      <li><a href="/school/{{$school->id}}">
                        {{$school->name}}
                      </a></li>
                    @endforeach
                  </ul>
                </div>
              </small>
            @endif


			</div>
		</div>
	</div>





{{-- 			<small class="school-select-wrap">
				School:
				<div class="dropdown pull-right">
					<a href="javascript:;" class="link school-select" data-toggle="dropdown">
						{{$mySchool->name}}
					</a>
					<ul class="dropdown-menu">
						@foreach ($schools as $school)
							<li><a href="/school/{{$school->id}}">
								{{$school->name}}
								@if ($mySchool->id == $school->id)
									<i class="fa fa-check text-success"></i>
								@endif
							</a></li>
						@endforeach
					</ul>
				</div>
			</small>
			<span>
				{{Form::open(['method'=>'get'])}}
					{{Form::text('keyword', '', ['placeholder'=>'Search'])}}
				{{Form::close()}}
			</span>

 --}}
		</div>


	</div>




	<div class="container category-area" ng-app>
		<div class="col-md-1">
			<span class="category-name">{{Lang::get('category.category')}}:</span>
		</div>
		<div class="col-md-11">
			<ul class="nav nav-pills">
				<li role="presentation" ng-class="{'active': 0=={{$category_id}}}"><a href="/">{{Lang::get('category.all')}}</a></li>
				@foreach ($categories as $category)
					<li role="presentation" ng-class="{'active': {{$category->id}}=={{$category_id}}}"><a href="/school/{{$mySchool->id}}/category/{{$category->id}}">{{$category->name2}}</a></li>
				@endforeach
			</ul>
		</div>

		<div class="col-md-12">
			<hr>
			<ul class="sort-option">
				<li><a href="?sort=latest" ng-class="{'sort-active': '{{Input::get("sort") == "latest"}}'}">{{Lang::get('sort.latest')}}</a></li>
				<li><a href="?sort=more-reward" ng-class="{'sort-active': '{{Input::get("sort") == "more-reward"}}'}">{{Lang::get('sort.more-reward')}}</a></li>
				<li><a href="?sort=less-expiration" ng-class="{'sort-active': '{{Input::get("sort") == "less-expiration"}}'}">{{Lang::get('sort.less-expiration')}}</a></li>
				<li><a href="?sort=less-participator" ng-class="{'sort-active': '{{Input::get("sort") == "less-participator"}}'}">{{Lang::get('sort.less-participator')}}</a></li>
			</ul>
		</div>
	</div>


	<div class="container">
	
		@if (isset($keyword))
			<p class="text-muted">
				{{-- Search for <span class="text-danger">{{$keyword}}</span>, {{count($tasks)}} task(s) matched. --}}
				{{Lang::get('message.search-for')}}
				<span class="text-danger">{{$keyword}}</span>，
				{{Lang::get('message.found')}}
				<span class="text-danger">{{count($tasks)}}</span>
				{{Lang::get('message.task(s)')}}
			</p>
		@else
		@endif

		@if (count($tasks))
			<div class="list-group list-group-lg">
				@foreach ($tasks as $task)

					@if ($task->activeUserFilter() == 'active')

					<div href="/task/{{$task->id}}" class="list-group-item">

						<div class="item-inline">
							<a href="/user/{{$task->user->id}}">
								<img class="avatar-sm" src="{{URL::asset('/avatar/' . $task->user->avatar )}}" data-toggle="tooltip" data-placement="left" title="{{$task->user->username}}">
							</a>
						</div>


						<div class="item-inline">
							<div class="list-group-item-heading">
								<div style="float: left; padding-top: 2px">
									@if ($task->amount == NULL)
										<i class="fa fa-circle cw-circle-unpaid" data-toggle="tooltip" data-placement="top" title="{{Lang::get('task.bounty-unhosted')}}"></i>
									@else
										<i class="fa fa-circle cw-circle-paid" data-toggle="tooltip" data-placement="top" title="{{Lang::get('task.bounty-hosted')}}"></i>
									@endif
									@if ($task->type == 1)
										<span class="label label-success">&yen; {{$task->amount}}</span>
										<span class="label label-warning">{{Lang::get('task.reward')}}</span>
									@elseif($task->type == 2)
										<span class="label label-success">&yen; {{$task->amountStart}} ~ {{$task->amountEnd}}</span>
										<span class="label label-danger">{{Lang::get('task.bid')}}</span>
									@endif
								</div>
								<span class="cw-task-title" style="display: inline-block; padding-top: 2px;"><a href="/task/{{$task->id}}">{{{$task->title}}}</a></span>
							</div>
							<span class="metadata">
								<a href="/user/{{$task->user->id}}" class="property">
									<i class="fa fa-user"></i> {{{$task->user->username}}}
								</a>
								<span class="property" data-toggle="tooltip" data-placement="right" title="{{$task->created_at}}">
									<i class="fa fa-calendar"></i>
									{{-- {{explode(' ', $task->created_at)[0]}} --}}
									<span id="created_at_{{$task->id}}"></span>发布
								</span>
								{{-- <p id="test{{$task->id}}"></p> --}}
								<script>
									moment.lang('zh-cn');
									// $('#test{{$task->id}}').html('{{$task->created_at}}');
									$('#created_at_{{$task->id}}').html(moment('{{$task->created_at}}', 'YYYY-MM-DD hh:mm:ss').fromNow());
								</script>
							</span>
						</div>

						<div class="item-inline pull-right metadata" style="width: 170px; padding-top: 10px;">
							<h4>
								@if ($task->winning_commit_id != 0 || $task->winning_quote_id != 0)
									<span data-toggle="tooltip" data-placement="top" title="{{Lang::get('task.people-win-bid', array('number'=>1))}}">1</span>
								@else
									<span data-toggle="tooltip" data-placement="top" title="{{Lang::get('task.people-win-bid', array('number'=>0))}}">0</span>
								@endif
								/
								<span data-toggle="tooltip" data-placement="top" title="{{Lang::get('task.people-participate', array('number'=>count($task->bidder)))}}">{{count($task->bidder)}}</span>
								<span style="padding-left: 20px;">
									@if ($task->state == 4)
										<i class="text-danger fa fa-clock-o"></i>
										<span class="text-danger task-state">{{Lang::get('task.task-end')}}</span>
									@elseif($task->state == 1 || $task->state == 2)
										<i class="text-success fa fa-clock-o"></i>
										<span class="text-success task-state">{{Lang::get('task.bidding')}}...</span>
									@elseif($task->state ==5)
										<i class="fa fa-clock-o"></i>
										<span class="task-state">{{Lang::get('task.expired')}}</span>
									@endif
								</span>
							</h4>
						</div>
					</div>

					@endif



				@endforeach
			</div>
			{{-- Paginator --}}
			{{$tasks->links()}}
		@else
			@if (!isset($keyword))
				<div class="alert alert-danger">{{Lang::get('task.no-task-published-ever')}}</div>
			@endif
		@endif

	</div>

@stop