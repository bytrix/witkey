@extends('task.master')

@section('style')
@parent
<style>
/*	.avatar-sm{
		cursor: pointer;
		width: 30px;
		margin-right: 12px;
		margin-bottom: 4px;
	}
	.avatar-sm:hover{
		box-shadow: 0 0 2px #337ab7;
	}*/
	.avatar-sm{
		margin-top: 5px;
	}
	.thumbnail{
		margin-bottom: 35px;
	}
	.time{
		color: #999;
		display: block;
		text-align: center;
	}
	.item-inline{
		display: inline-block;
	}
	.item-inline .avatar-sm{
		float: left;
	}
/*	div#summary{
		font-size: 18px;
		padding-left: 70px;
		word-break: break-all;
	}*/
	.no{
		font-size: 20px;
		color: #ccc;
		display: inline-block;
		width: 40px;
	}

/*	#editor {
		overflow:scroll;
	}*/

	#edit,#admin{
		padding-left: 3px;
		padding-top: 1px;
	}
	#favorite{
		padding-left: 1px;
		padding-top: 1px;
	}
	#edit:hover{
		background-color: #337ab7;
	}
	#admin:hover, .open #admin{
		background-color: #5cb85c;
	}
	#favorite:hover{
		background-color: #c00;
	}

	.favorited, .favorited i{
		color: #fff;
		background-color: #c00;
	}

	.widget{
		font-size: 0.7em;
		cursor: pointer;
		color: #666;
		text-decoration: none;
		/*background-color: #aaa;*/
		width: 30px;
		height: 30px;
		display: inline-block;
		text-align: center;
		line-height: 30px;
		border-radius: 50%;
		overflow: hidden;
	}
	.widget:hover{
		background-color: #ccc;
	}
	.widget-body{
		position: relative;
		top: 0px;
		transition: 0.3s;
	}
	.widget:hover.widget .widget-body, .open .widget-body{
		color: #fff;
		top: -30px;
	}

/*
	#tip{
		display: block;
		margin-left: -20px;
		position: absolute;
		color: #666;
		font-size: 14px;
		width: 60px;
		text-align: center;
	}
*/


	.price{
		/*background-color: red;*/
		/*display: block;*/
		font-weight: bold;
		height: 35px;
		line-height: 30px;
		padding-left: 10px;
		/*padding-right: 20px;*/
	}
	.price>h4{
		font-weight: bold;
		color: orange;
	}
	#edit-price{
		cursor: pointer;
	}
	.breadcrumb{
		background-color: rgba(0, 0, 0, 0.0);
	}
	.content-heading{
		margin-top: 40px;
	}
	.iter-task i,
	.iter-task-disabled i{
		width: 16px;
		height: 16px;
		line-height: 16px;
		text-align: center;
		border-radius: 4px;
		/*transition: 0.15s;*/
	}
	.iter-task:hover i{
		color: #fff;
		background-color: #245269;
	}
</style>
<!-- {{HTML::style(URL::asset('assets/style/cover.css'))}} -->
{{-- {{HTML::style(URL::asset('assets/extension/emoji-picker/lib/css/nanoscroller.css'))}} --}}
{{-- {{HTML::style(URL::asset('assets/extension/emoji-picker/lib/css/emoji.css'))}} --}}
{{-- {{HTML::style(URL::asset('assets/style/bootstrap3-wysihtml5.min.css'))}} --}}
{{ HTML::style(URL::asset('assets/style/simditor.css')) }}
@stop

@section('script')
<script>
	function favorite() {
		$('#favorite').addClass('favorited');
		// $('#favorite').removeClass('fa-heart-o');
		$('#favorite').attr('data-original-title', "{{Lang::get('message.uncollect')}}");
		// $('#tip').html('Collected');
	}
	function unfavorite() {
		$('#favorite').removeClass('favorited');
		// $('#favorite').addClass('fa-heart-o');
		$('#favorite').attr('data-original-title', "{{Lang::get('message.collect')}}");
		// $('#tip').html('Collect');
	}
	$(function() {
		// $('#edit').click(function() {
		// 	window.location.href = "/task/{{$task->id}}/edit";
		// });
		$.ajax({
			type: 'post',
			url: '/api/hasFavoriteTask/'+{{$task_id}},
			success: function(state) {
				// alert(state);
				if (state == 'true') {
					favorite();
				} else if(state == 'false') {
					unfavorite();
				}
			}
		});

		$('select').select2({
			theme: "bootstrap"
		});

		$('#edit-price').click(function() {
			$('#priceDialog').modal({
				backdrop: false
			});
		});

		// var editor = new Simditor({
		// 	textarea: $('#editor'),
		// 	upload: true,
		// });

	});
</script>
{{HTML::script(URL::asset('assets/script/angular.js'))}}
{{HTML::script(URL::asset('assets/script/moment.js'))}}
{{HTML::script(URL::asset('assets/script/moment-with-locales.min.js'))}}
{{HTML::script(URL::asset('assets/script/jquery.plugin.js'))}}
{{HTML::script(URL::asset('assets/script/jquery.countdown.min.js'))}}
{{HTML::script(URL::asset('assets/script/jquery.countdown-zh-CN.js'))}}

{{ HTML::script(URL::asset('assets/script/module.js')) }}
{{ HTML::script(URL::asset('assets/script/hotkeys.js')) }}
{{ HTML::script(URL::asset('assets/script/uploader.js')) }}
{{ HTML::script(URL::asset('assets/script/simditor.js')) }}

<!--
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/nanoscroller.min.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/tether.min.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/config.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/util.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/jquery.emojiarea.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/emoji-picker.js'))}}
-->

{{-- {{HTML::script(URL::asset('assets/script/wysihtml5x-toolbar.min.js'))}} --}}
{{-- {{HTML::script(URL::asset('assets/script/handlebars.runtime.min.js'))}} --}}
{{-- {{HTML::script(URL::asset('assets/script/bootstrap3-wysihtml5.min.js'))}} --}}

@stop

@section('content')

	<div class="container" ng-app>
		{{-- Modify Price Dialog --}}
<!-- 		<div class="modal fade" id="priceDialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">

					{{Form::open(['url'=>"/task/$task->id/modifyPrice/"])}}

					<div class="modal-header">
						<h4 class="modal-title">{{Lang::get('task.modify-price')}}</h4>
					</div>
					<div class="modal-body">
						{{-- {{Form::select('category', $categories, false, ['class'=>'form-control'])}} --}}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-yen"></i>
							</span>
							{{ Form::text('price', $task->amount, ['class'=>'form-control']) }}
						</div>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-default" data-dismiss="modal">{{Lang::get('message.cancel')}}</a>
						{{Form::hidden('task_id', $task->id)}}
						{{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary'])}}
					</div>

					{{Form::close()}}

				</div>
			</div>
		</div> -->

		{{-- Modify Category Dialog --}}
		<div class="modal fade" id="categoryDialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">

					{{Form::open(['url'=>"/task/$task->id/changeCategory/"])}}

					<div class="modal-header">
						<h4 class="modal-title">{{Lang::get('task.move-to-another-category')}}</h4>
					</div>
					<div class="modal-body">
						{{-- {{Form::select('category', $categories, false, ['class'=>'form-control'])}} --}}
						@foreach ($categories as $category)
							<div class="radio">
								@if ($category->id == $task->category_id)
									<input type="radio" name="category_id" value="{{$category->id}}" id="{{$category->id}}" checked>
								@else
									<input type="radio" name="category_id" value="{{$category->id}}" id="{{$category->id}}">
								@endif
								<label for="{{$category->id}}">{{$category->name2}}</label>
							</div>
						@endforeach
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-default" data-dismiss="modal">{{Lang::get('message.cancel')}}</a>
						{{Form::hidden('task_id', $task->id)}}
						{{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary'])}}
					</div>

					{{Form::close()}}

				</div>
			</div>
		</div>

		{{-- Delete Task Dialog --}}
		<div class="modal fade" id="deleteDialog">
			<div class="modal-dialog modal-sm">

				{{Form::open(['url'=>"/task/$task->id/delete", 'name'=>'deleteForm'])}}

				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{Lang::get('task.reason-for-deleting')}}</h4>
					</div>
					<div class="modal-body">
						{{Form::textarea('reason', '', ['class'=>'form-control', 'required', 'ng-model'=>'reason'])}}
					</div>
					<div class="modal-footer">
						<a href="javascript:;" data-dismiss="modal" class="btn btn-default">{{Lang::get('message.cancel')}}</a>
						{{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary', 'ng-disabled'=>'deleteForm.$invalid'])}}
					</div>
				</div>

				{{Form::close()}}

			</div>
		</div>


		<div class="col-md-8">

			<div class="page-header">
					@if ($task->type == 1)
						<span class="cw-heading-tag cw-reward-heading">
							{{Lang::get('task.reward')}}
							|
							@if ($task->amount == NULL)
								{{Lang::get('task.bounty-unhosted')}}
							@else
								{{Lang::get('task.bounty-hosted')}}
							@endif
						</span>
					@elseif($task->type == 2)
						<span class="cw-heading-tag cw-bid-heading">
							{{Lang::get('task.bid')}}
							|
							@if ($task->amount == NULL)
								{{Lang::get('task.bounty-unhosted')}}
							@else
								{{Lang::get('task.bounty-hosted')}}
							@endif
						</span>
					@endif

					<div class="pull-right" style="font-size: 25px; margin-top: -10px; width: 190px;">
						{{-- Edit Button --}}
						<div class="col-sm-4">
							@if (Auth::check() && $task->user_id == Auth::user()->id)
								<a class="widget" id="edit" href="/task/{{$task->id}}/edit" data-toggle="tooltip" data-placement="top" title="{{Lang::get('message.edit')}}">
									<span class="widget-body">
										<i class="fa fa-edit"></i>
										<i class="fa fa-edit"></i>
									</span>
								</a>
							@endif
						</div>
						{{-- Favorite Button --}}
						<div class="col-sm-4">
							<a class="widget" id="favorite" data-toggle="tooltip" data-placement="top" title="{{Lang::get('message.collect')}}">
								<span class="widget-body">
									<i class="fa fa-heart-o"></i>
									<i class="fa fa-heart-o"></i>
								</span>
							</a>
							{{-- <span id="tip">favorite</span> --}}
						</div>
						{{-- Admin Area --}}
						<div class="col-sm-4">
							@if (Auth::check() && Auth::user()->getPermission()['Manager'][2])

								<div class="dropdown">
									
									<a class="widget" id="admin" data-toggle="dropdown" data-placement="top" title="{{Lang::get('message.admin')}}">
										<span class="widget-body">
											<i class="fa fa-folder-open-o"></i>
											<i class="fa fa-folder-open-o"></i>
										</span>
									</a>

									<ul class="dropdown-menu">
										<li><a href="javascript:;" data-backdrop="static" data-toggle="modal" data-target="#categoryDialog">{{Lang::get('task.move-to-another-category')}}</a></li>
										<li><a href="javascript:;" data-backdrop="static" data-toggle="modal" data-target="#deleteDialog">{{Lang::get('task.delete-this-task')}}</a></li>
										<li><a target="blank" href="/reportUser/{{$task->user->id}}">{{Lang::get('task.report-this-user')}}</a></li>
									</ul>

								</div>

							@endif
						</div>

					</div>
					<div></div>
					<span>
						<h3 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block; max-width: 700px;" title="{{$task->title}}">
							{{$task->title}}
						</h3>
					</span>
				<script>

				$('#favorite').click(function() {
					$.ajax({
						type: 'post',
						url: '/api/markFavoriteTask/' + {{$task_id}},
						success: function(state) {
							if (state == 'remove') {
								unfavorite();
							} else if(state == 'create') {
								favorite();
							}
						},
						error: function(data) {
							console.log(data);
							window.location.href = '/login';
						}
					});
				});
				</script>
			</div>

			<ol class="breadcrumb">
				<li><a href="/">{{Lang::get('task.list')}}</a></li>
				<li>
					<a href="/school/{{$task->place}}/category/{{$task->category_id}}">{{$task->category->name2}}</a>
				</li>
			</ol>
			

			<div class="col-sm-6">
				<h4><span>{{Lang::get('task.task-id')}}:</span> #{{$task->id}}</h4>
				@if ($task->type == 1)
					<h4>
						<span>{{Lang::get('task.amount-reward')}}:</span>
<!-- 						@if (Auth::check() && Auth::user()->id == $task->user->id)
							<span class="amount cw-text-red price" id="edit-price" data-toggle="tooltip" data-placement="right" title="点击修改">&yen; {{$task->amount}}</span>
						@else
							<span class="amount cw-text-red price">&yen; {{$task->amount}}</span>
						@endif -->
						<span class="amount cw-text-red price">&yen; {{$task->amount}}</span>
					</h4>
				@elseif ($task->type == 2)
					<h4>
						<span>{{Lang::get('task.amount-budget')}}:</span>
						<span class="amount cw-text-red price">&yen; {{$task->amountStart}} ~ {{$task->amountEnd}}</span>
					</h4>
				@endif
			</div>

			<div class="col-sm-6">
				<h4><span>{{Lang::get('message.school')}}:</span>
				@if ($task->place == NULL)
					<span class="label label-danger">No School</span>
				@else
					{{-- {{Academy::get($task->user->school)->name}}</h4> --}}
					{{$school->name}}
				@endif
				{{-- <h4><span>Expiration:</span> {{$task->expiration}}</h4> --}}
				<h4>
					<span>{{Lang::get('task.expiration')}}:</span>
					@if ($task->state == 4)
						<span class="text-danger">{{ Lang::get('task.task-end') }}</span>
					@elseif($task->state == 5)
						<span class="text-muted" data-toggle="tooltip" data-placement="bottom" title="{{$task->expiration}}">{{Lang::get('task.expired')}}</span>
						@if (Auth::check() && $task->user->id == Auth::user()->id)
							<a href="javascript:;" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal">{{Lang::get('task.delay')}}</a>

							<!-- Modal -->
							<div class="modal fade" data-backdrop="static" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog modal-sm" role="document">
							    <div class="modal-content">


							      	{{Form::open(['url'=>"/task/$task_id/delay"])}}
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title" id="myModalLabel">{{Lang::get('task.delay-time')}}</h4>
								      </div>
								      <div class="modal-body">
											{{Form::text('expiration', '', ['class'=>'form-control', 'id'=>'expiration', 'placeholder'=>'0000-00-00 00:00:00'])}}
											<script>
											$('#expiration').datetimepicker({
												language: 'zh-CN',
												startDate: '2010-01-01'
											});
											</script>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('message.cancel')}}</button>
								        {{-- <button type="submit" class="btn btn-primary">Save changes</button> --}}
								        {{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary'])}}
								      </div>
							      	{{Form::close()}}



							    </div>
							  </div>
							</div>

						@endif
					@else
						<span data-toggle="tooltip" data-placement="bottom" title="{{ $task->expiration }}" id="expiration"></span>
					@endif
					<script>
						moment.lang('zh-cn');
						var strExpiration = "{{ $task->expiration }}";
						// var expiration = new Date(strExpiration.replace(/-/g, "/"));
						var expiration = new Date(strExpiration);
						var deltaSecond = expiration - new Date();
						$('#expiration').html(moment().add(deltaSecond).calendar());
					</script>
				</h4>




			</div>

			<div class="col-sm-12" ng-app>
				<ul class='task-procedure state' ng-controller="stateController">
					{{-- <span ng-bind="state"></span> --}}
					<li class="col-md-3" ng-class="{'light': state == 1, 'active': state == 1 || state == 2 || state == 3 || state == 4}">{{Lang::get('task.enrollment')}}</li>
					<li class="col-md-3" ng-class="{'light': state == 2, 'active': state == 2 || state == 3 || state == 4}">{{Lang::get('task.performing')}}</li>
					<li class="col-md-3" ng-class="{'light': state == 3, 'active': state == 3 || state == 4}">{{Lang::get('task.check')}}</li>
					<li class="col-md-3" ng-class="{'light': state == 4, 'active': state == 4}">{{Lang::get('task.finish')}}</li>
				</ul>

				<script>
					var stateController = function($scope, $http) {
						$http.get('/api/taskState/{{$task_id}}')
							.success(function(response) {
								$scope.state = response;
							});
					}
				</script>

				@if ($task->state != 4)
					<div class="time">
						距离任务结束时间：
						@if ($task->state != 5)
							<span id="countdown"></span>
						@else
							<span>{{Lang::get('task.over')}}</span>
						@endif
						<script>
							$('#countdown').countdown({until: expiration});
						</script>
					</div>
				@endif

				{{-- count: {{mb_strlen(Purifier::clean($task->detail, 'plainText'))}} --}}
				<h4 class="content-heading"><strong>{{Lang::get('task.description')}}:</strong></h4>
				<div class="detail" id="detail">
					@if ($attachment != NULL)
						<p>
							Attachment: 
							@if ($attachment->file_ext == "")
								<a href="/file/{{$task->user->id}}/{{$attachment->file_hash}}">{{$attachment->file_name}}</a>
							@else
								<a href="/file/{{$task->user->id}}/{{$attachment->file_hash}}.{{$attachment->file_ext}}">{{$attachment->file_name}}</a>
							@endif
						</p>
					@endif
					{{str_limit($task->detail, 2000)}}
				</div>
				@if (mb_strlen(Purifier::clean($task->detail, 'plainText')) > 2000)
					<div>
						<a href="javascript:;" id="unfold">
							<i class='fa fa-arrow-down'></i> {{Lang::get('message.unfold')}}
							 ({{ round((mb_strlen(Purifier::clean($task->detail, 'plainText')) - 2000) / mb_strlen(Purifier::clean($task->detail, 'plainText')) * 100) }}%)
						</a>
					</div>
					<script>
					$('#unfold').attr('folded', "true");
					$('#unfold').click(function() {
						// alert($(this).html());
						$('#detail').html("{{$task->detail}}");
						if($(this).attr('folded') == "false") {
							$(this).html("<i class='fa fa-arrow-down'></i> {{Lang::get('message.unfold')}} ({{ round((mb_strlen($task->detail) - 2000) / mb_strlen($task->detail) * 100) }}%)");
							$('#detail').html("{{str_limit($task->detail, 2000)}}");
							$(this).attr('folded', "true");
						} else {
							// alert($(this).attr('folded'));
							$(this).html("<i class='fa fa-arrow-up'></i> {{Lang::get('message.fold')}}");
							$(this).attr('folded', "false");
						}
					})
					</script>
				@endif

				<h4 class="content-heading">
					@if (isset($commit_sum))
						<strong>
							{{Lang::get('task.bidder')}}
							<span data-toggle="tooltip" data-placement="top" title="{{count($task->bidder)}}人投稿">({{count($task->bidder)}}</span>
							/
							<span data-toggle="tooltip" data-placement="top" title="{{$commit_sum}}份投稿说明">{{$commit_sum}})</span>
						</strong>
					@elseif(isset($quote_sum))
						<strong>
							{{Lang::get('task.bidder')}}
							<span data-toggle="tooltip" data-placement="top" title="{{count($task->bidder)}}人报价">({{count($task->bidder)}}</span>
							/
							<span data-toggle="tooltip" data-placement="top" title="{{$quote_sum}}份报价说明">{{$quote_sum}})</span>
						</strong>

						@if (count($task->bidder) > 1)
							<span class="text-danger" style="margin-left: 30px;">
								{{Lang::get('average-quote')}}:
								&yen;{{$quote_price_avg}}
							</span>
						@endif
					@endif
				</h4>


				<div class="avatar-bar">
					@foreach ($task->bidder as $bidder)
						{{-- <img class='avatar-sm' onclick="window.location.href='/user/{{$bidder->id}}'" src="{{URL::asset('/avatar/' . $bidder->avatar )}}" data-toggle="tooltip" title="{{$bidder->username}}" data-placement="top"> --}}
						<a href="/user/{{$bidder->id}}">
							<img class='avatar-xs' src="{{URL::asset('/avatar/' . $bidder->avatar )}}" data-toggle="tooltip" title="{{$bidder->username}}" data-placement="top">
						</a>

					@endforeach
				</div>


				@if (Auth::check())

					@if ($task->winningQuote != NULL && count($task->winningQuote->latestCommit) && ($task->user->id == Auth::user()->id || $task->winningQuote->user->id == Auth::user()->id) )
						<div class="panel panel-default">
							<div class="panel-heading">
								<strong>Latest Commit</strong>
								@if ($task->state == 4)
									<span class="label label-danger pull-right">Paid &yen;{{$task->amount}}</span>
								@endif
							</div>
							<div class="panel-body">
								<p class="metadata">
									<a href="/user/{{$task->winningQuote->latestCommit->first()->user->id}}">
										{{HTML::image(URL::asset('/avatar/' . $task->winningQuote->latestCommit->first()->user->avatar), '', ['class'=>'avatar-sm'])}}
									</a>
									from
									<a href="/user/{{$task->winningQuote->latestCommit->first()->user->id}}">
										<strong>{{$task->winningQuote->latestCommit->first()->user->username}}</strong>
									</a>
									committed at <span id="committed_at">{{$task->winningQuote->latestCommit->first()->created_at}}</span>
								</p>
								<div id="summary">
									{{$task->winningQuote->latestCommit->first()->summary}}
									@if ($task->user->id == Auth::user()->id && $task->state == 3)
										<a href="/pay/{{$task->winningQuote->latestCommit->first()->uuid}}" class="btn btn-success pull-right">{{ Lang::get('task.pay') }}</a>
									@endif
								</div>
							</div>
						</div>
					@endif

					<div class="list-group">

						@if (isset($commit_sum) && (Auth::user()->isBidder($task->id) || Auth::user()->id == $task->user->id))

							@if (Auth::user()->isBidder($task->id))
								@foreach ($commits as $commit)
									<div class="list-group-item">

										{{-- no --}}
										{{-- <span class="no"># {{$commit->id}}</span> --}}

										{{-- avatar --}}
										<a href="/user/{{$commit->user->id}}">
											{{HTML::image(URL::asset('/avatar/' . $commit->user->avatar ), '', ['class'=>'avatar-sm', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$commit->user->username])}}
										</a>

										{{-- date --}}
										<span class="metadata">
											<a href="/user/{{$commit->user->id}}"><strong>{{$commit->user->username}}</strong></a>
											{{Lang::get('task.committed-at')}}
											<span id="committed_at_{{ $commit->id }}" data-toggle="tooltip" data-placement="right" title="{{$commit->created_at}}"></span>
											<script>
											// var date = new Date("{{$commit->created_at}}");
											$("#committed_at_{{ $commit->id }}").html(moment("{{$commit->created_at}}", "YYYY-MM-DD hh:mm:ss").fromNow());
											</script>
										</span>

										@if ($task->winning_commit_id == $commit->id)
											<span class="label label-danger">
												<i class="fa fa-flag"></i>
												Win
											</span>
										@endif

										{{-- bid_btn --}}
										@if ($task->user->id == Auth::user()->id && $task->id != 4)
											<a href="/pay/{{$commit->uuid}}" class="btn btn-success pull-right">{{ Lang::get('task.pay') }}</a>
										@endif

										<div id="summary">
											{{$commit->summary}}
										</div>
									</div>
								@endforeach
							@elseif(Auth::user()->id == $task->user->id)
								@foreach ($task->bidder as $bidder)
									<div class="list-group-item">

										{{-- no --}}
										{{-- <span class="no"># {{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->id}}</span> --}}

										<!-- commit id -->
										<p class="commit_id">
											<!-- Commit ID: -->
											{{ Lang::get('task.commit-id') }}：#{{ $commit_id = $bidder->findLatestCommitById($bidder->id, $task->id)->first()->id }}
										</p>

										{{-- avatar --}}
										<a href="/user/{{$bidder->id}}">
											{{HTML::image(URL::asset('/avatar/' . $bidder->avatar ), '', ['class'=>'avatar-sm', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$bidder->username])}}
										</a>

										{{-- date --}}
										<span class="metadata">
											<a href="/user/{{$bidder->id}}"><strong>{{$bidder->username}}</strong></a>
											{{Lang::get('task.committed-at')}}
											<span id="committed_at_{{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->id}}" data-toggle="tooltip" title="{{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->created_at}}" data-placement="right">
												{{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->created_at}}
											</span>
											<script type="text/javascript">
												$('#committed_at_{{ $bidder->findLatestCommitById($bidder->id, $task->id)->first()->id }}').html(moment("{{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->created_at}}", "YYYY-MM-DD hh:mm:ss").fromNow());
											</script>

										</span>


										{{-- {{var_dump($task->winning_commit_id)}} --}}

										@if ($task->winning_commit_id == $bidder->findLatestCommitById($bidder->id, $task->id)->first()->id)
											<span class="label label-danger">
												<i class="fa fa-flag"></i>
												{{ Lang::get('task.win') }}
											</span>
										@endif

										{{-- bid_btn --}}
										@if ($task->user->id == Auth::user()->id && $task->state != 4)
											<a href="/pay/{{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->uuid}}" class="btn btn-success pull-right">{{ Lang::get('task.pay') }}</a>
										@endif

										<div id="summary">
											{{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->summary}}
											<p style="margin-top: 20px; text-align: right; font-size: 14px;">
												@if ($bidder->commit_num($task_id, $bidder->commit) - 1 != 0)
													<a href="/task/{{ $task_id }}/commit/{{ $bidder->id }}">
														<!-- more history task description(s) -->
														{{ Lang::get('task.more-history-task-description', array('commit_num'=>$bidder->commit_num($task_id, $bidder->commit) - 1)) }}
													</a>
												@endif
											</p>
										</div>


									</div>
								@endforeach
							@endif

							{{$commits->links()}}

						@elseif(isset($quote_sum))

							@foreach ($task->bidder as $bidder)
								<div class="list-group-item">

									{{-- no --}}
									{{-- <span class="no"># {{$quote->id}}</span> --}}

									{{-- avatar --}}
									<a href="/user/{{$bidder->id}}">{{HTML::image(URL::asset('/avatar/' . $bidder->avatar ), '', ['class'=>'avatar-sm', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$bidder->username])}}</a>

									{{-- username & date --}}
									<span class="metadata">
										<a href="/user/{{$bidder->id}}"><strong>{{$bidder->username}}</strong></a>
										quoted at 
										{{$bidder->findLatestQuoteById($bidder->id, $task->id)->first()->created_at}}
									</span>


									@if ($task->winning_quote_id == $bidder->findLatestQuoteById($bidder->id, $task->id)->first()->id)
										<span class="label label-danger">
											<i class="fa fa-flag"></i>
											Win
										</span>
									@endif

									{{-- bid_btn --}}
									@if ($task->user->id == Auth::user()->id && $task->state == 1)
										<a href="{{$task_id}}/hosting/{{$task->type . $bidder->findLatestQuoteById($bidder->id, $task->id)->first()->id}}" class="btn btn-danger pull-right">Bid</a>
									@endif

									<div class="price pull-right" data-toggle="tooltip" data-placement="left" title="Quote Price">
										<h4>&yen; {{$bidder->findLatestQuoteById($bidder->id, $task->id)->first()->price}}</h4>
									</div>

									<div id="summary">
										{{$bidder->findLatestQuoteById($bidder->id, $task->id)->first()->summary}}
{{-- 
										@if ($task->winningQuote != NULL && $task->winning_quote_id == $bidder->findLatestQuoteById($bidder->id, $task->id)->first()->id)
											<div class="list-group">
												<div class="list-group-item">
													<p>---------------------- LATEST COMMIT ------------------------</p>
													<p>
														{{$task->winningQuote->latestCommit->first()->summary}}
													</p>
													<p>
														committed at {{$task->winningQuote->latestCommit->first()->created_at}}
													</p>
												</div>
											</div>
										@endif
 --}}
									</div>

								</div>
							@endforeach

						@endif

					</div>



{{-- 
					@foreach ($task->bidder as $bidder)
						<p>
							{{$bidder->username}}

							{{$bidder->findLatestQuoteById($bidder->id, $task->id)->first()->summary}}
						</p>
					@endforeach

 --}}
					@if (Auth::user()->truename())

						@if ($task->winningQuote != NULL && $task->winningQuote->user->id == Auth::user()->id)
							<p class="text-success">You are the best person the demander wanted, please commit your job soon!</p>
						@endif

						{{-- COMMIT AREA --}}
						@if (( ($task->type == 1 && $task->state == 1) || ($task->state == 2 || $task->state == 3) )  && $task->user->id != Auth::user()->id )


							{{Form::open(['url'=>"/task/$task_id/commit"])}}
								{{Form::label('summary', Lang::get('message.summary'))}}
								{{-- <div class="form-group emoji-picker-container">
									{{Form::textarea('summary', '', ['class'=>'form-control textarea-control textarea', 'placeholder'=>'Commit summary', 'data-emojiable'=>'true', 'rows'=>'5'])}}
								</div> --}}
								<div class="form-group">
									{{Form::textarea('summary', '', ['id'=>'editor', 'class'=>'form-control textarea', 'placeholder'=>Lang::get('task.commit-summary')])}}
								</div>
								<div class="form-group">
									{{Form::submit(Lang::get('task.commit'), ['class'=>'btn btn-danger'])}}
								</div>
								{{Form::hidden('type', $task->type)}}
								@if ($task->winningCommit != NULL)
									{{Form::hidden('commit_id', $task->winningCommit->id)}}
								@elseif ($task->winningQuote != NULL)
									{{Form::hidden('quote_id', $task->winningQuote->id)}}
								@endif

								<script type="text/javascript">
									var editor = new Simditor({
										textarea: $('#editor'),
										upload: true,
									});
								</script>


							{{Form::close()}}
						@endif
						{{-- END COMMIT AREA --}}




						{{-- QUOTE AREA --}}
						@if ($task->type == 2 && $task->user->id != Auth::user()->id && $task->state == 1)

							{{Form::open(['url'=>"/task/$task_id/quote"])}}
								{{Form::label('price', Lang::get('task.price'))}}
								{{Form::text('price', '', ['class'=>'form-control', 'placeholder'=>Lang::get('task.price')])}}
								{{Form::label('summary', Lang::get('task.quote-summary'))}}
								<div class="form-group">
									{{Form::textarea('summary', '', ['class'=>'form-control', 'placeholder'=>Lang::get('task.quote-summary')])}}
								</div>
								<div class="form-group">
									{{Form::submit(Lang::get('task.quote'), ['class'=>'btn btn-danger'])}}
								</div>
							{{Form::close()}}
						@endif
						{{-- END QUOTE AREA --}}


					@else


						@if ($task->user->id != Auth::user()->id && $task->state != 4)
							{{Form::open()}}
								{{Form::label('summary', Lang::get('message.summary'))}}
								<div class="form-group">
									{{Form::textarea('summary', '', ['class'=>'form-control', 'placeholder'=>Lang::get('message.you-are-not-allowed-unless-pass-through-truename-authentication'), 'disabled'])}}
								</div>
								<div class="form-group">
								@if ($task->type == 1)
									{{Form::submit(Lang::get('task.commit'), ['class'=>'btn btn-danger', 'disabled'])}}
								@else if ($task->type == 2)
									{{Form::submit(Lang::get('task.quote'), ['class'=>'btn btn-danger', 'disabled'])}}
								@endif
								</div>
							{{Form::close()}}
						@endif



					@endif

				@else

					@if ($task->state != 4)
						{{Form::open()}}
							{{Form::label('summary', Lang::get('message.summary'))}}
							<div class="form-group">
								{{Form::textarea('summary', '', ['class'=>'form-control', 'placeholder'=>Lang::get('message.you-are-not-logged-in'), 'disabled'])}}
							</div>
							<div class="form-group">
								@if ($task->type == 1)
									{{Form::submit(Lang::get('task.commit'), ['class'=>'btn btn-danger', 'disabled'])}}
								@else if ($task->type == 2)
									{{Form::submit(Lang::get('task.quote'), ['class'=>'btn btn-danger', 'disabled'])}}
								@endif
							</div>
						{{Form::close()}}
					@endif

				@endif


				@if (count($errors))
					<div class="alert alert-danger">
						{{$errors->first()}}
					</div>
				@endif


			</div>

		</div>

		<div class="col-md-4">
			<div class="profile">
				<div>
					<img src="{{URL::asset('/avatar/' . $task->user->avatar )}}" class="thumbnail avatar-lg">
				</div>
				<h4>
					<span>{{Lang::get('message.publisher')}}: </span>
					<a data-toggle="tooltip" data-placement="top" title="{{Lang::get('message.view-tas-profile')}}" href="/user/{{$task->user->id}}">
						{{$task->user->username}}
					</a>
					<span>
						@if ($task->user->gender == 'M')
							<i class="fa fa-mars"></i>
						@elseif($task->user->gender == 'F')
							<i class="fa fa-venus"></i>
						@endif
					</span>
				</h4>

				


				<div class="contact">
				
				@if (strlen($task->user->dorm))
					@if (Auth::check() && ( $task->user->truename() || Auth::user()->id == $task->user->id ) )
						@if ($task->user->dorm == 'no')
							<p><i class="fa fa-map-marker"></i> <span class="label label-warning">{{ Lang::get('user.non-resident') }}</span></p>
						@else
							<p><i class="fa fa-map-marker"></i> {{$task->user->dorm}}</p>
						@endif
					@else
						<p data-toggle="tooltip" data-placement="left" title="通过实名认证后可见"><i class="fa fa-map-marker"></i> {{$task->user->asteriskResident()}}</p>
					@endif
				@endif
					
					@if (strlen($task->user->tel))
						@if (Auth::check() && ( $task->user->truename() || Auth::user()->id == $task->user->id ) )
							<p><i class="fa fa-phone"></i> {{$task->user->tel}}</p>
						@else
							<p data-toggle="tooltip" data-placement="left" title="通过实名认证后可见"><i class="fa fa-phone"></i> {{$task->user->asteriskTel()}}</p>
						@endif
					@endif

					@if (strlen($task->user->qq))
						@if (Auth::check() && ( $task->user->truename() || Auth::user()->id == $task->user->id ) )
							<p><i class="fa fa-qq"></i> {{$task->user->qq}}</p>
						@else
							<p data-toggle="tooltip" data-placement="left" title="通过实名认证后可见"><i class="fa fa-qq"></i> {{$task->user->asteriskQQ()}}</p>
						@endif
					@endif

				</div>

			</div>
		</div>



			<div class="col-md-12">
				<div style="clear: both">
					@if ($prev_task != NULL)
						<div class="cw-pager">
							<a href="/task/{{$prev_task->id}}" class="text-info iter-task">
								<i class="fa fa-angle-up"></i>
								{{Lang::get('task.task-prev')}}: {{$prev_task->title}}
							</a>
						</div>
					@else
						<div class="cw-pager">
							<span class="text-muted iter-task-disabled">
								<i class="fa fa-angle-up"></i>
								{{Lang::get('task.task-prev')}}: {{Lang::get('message.none')}}
							</span>
						</div>
					@endif
				</div>
				<div style="clear: both">
					@if ($next_task != NULL)
						<div class="cw-pager">
							<a href="/task/{{$next_task->id}}" class="text-info iter-task">
								<i class="fa fa-angle-down"></i>
								{{Lang::get('task.task-next')}}: {{$next_task->title}}
							</a>
						</div>
					@else
						<div class="cw-pager">
							<span class="text-muted iter-task-disabled">
								<i class="fa fa-angle-down"></i>
								{{Lang::get('task.task-next')}}: {{Lang::get('message.none')}}
							</span>
						</div>
					@endif
				</div>
			</div>
			



	</div>
{{-- 
	<script>
		$(function() {
			$('.textarea').wysihtml5({
				toolbar: {
					fa: true,
				}
			});
		});
	</script>
 --}}
@stop