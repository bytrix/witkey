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
	div#summary{
		font-size: 18px;
		padding-left: 50px;
	}
	.no{
		font-size: 20px;
		color: #ccc;
		display: inline-block;
		width: 40px;
	}
	#editor {
		overflow:scroll;
		/*max-height:300px;*/
	}
	a#edit, a.favorite{
		font-size: 0.8em;
		cursor: pointer;
		color: #666;
		text-decoration: none;
	}
	#edit{
		margin-left: 0.6em;
		margin-right: 0.7em;
	}
	#edit:hover{
		color: #337ab7;
	}
	.favorite:hover{
		color: red;
	}

	.favorite{
		cursor: pointer;
		font-size: 0.8em;
		margin-top: 0.3em;
		margin-right: 1.7em;
		color: #666;
	}
	#tip{
		display: block;
		margin-left: -20px;
		position: absolute;
		color: #666;
		font-size: 14px;
		width: 60px;
		text-align: center;
	}

	.price{
		/*background-color: red;*/
		/*display: block;*/
		font-weight: bold;
		height: 35px;
		line-height: 30px;
		padding-left: 10px;
		padding-right: 20px;
	}
	.price>h4{
		font-weight: bold;
		color: orange;
	}
	
</style>
{{HTML::style(URL::asset('assets/style/cover.css'))}}
{{HTML::style(URL::asset('assets/extension/emoji-picker/lib/css/nanoscroller.css'))}}
{{HTML::style(URL::asset('assets/extension/emoji-picker/lib/css/emoji.css'))}}
{{HTML::style(URL::asset('assets/style/bootstrap3-wysihtml5.min.css'))}}
@stop

@section('script')
<script>
	function favorite() {
		$('#favorite').addClass('fa-heart');
		$('#favorite').removeClass('fa-heart-o');
		$('#favorite').attr('data-original-title', 'Uncollect');
		$('#tip').html('Collected');
	}
	function unfavorite() {
		$('#favorite').removeClass('fa-heart');
		$('#favorite').addClass('fa-heart-o');
		$('#favorite').attr('data-original-title', 'Collect');
		$('#tip').html('Collect');
	}
	$(function() {
		$('#edit').click(function() {
			window.location.href = "/task/{{$task->id}}/edit";
		});
		$.ajax({
			type: 'post',
			url: '/hasFavoriteTask/'+{{$task_id}},
			success: function(state) {
				if (state == 'true') {
					favorite();
				} else if(state == 'false') {
					unfavorite();
				}
			}
		});
	});
</script>
{{HTML::script(URL::asset('assets/script/moment.js'))}}
{{HTML::script(URL::asset('assets/script/moment-with-locales.min.js'))}}
{{HTML::script(URL::asset('assets/script/jquery.plugin.js'))}}
{{HTML::script(URL::asset('assets/script/jquery.countdown.min.js'))}}
{{HTML::script(URL::asset('assets/script/jquery.countdown-zh-CN.js'))}}
{{HTML::script(URL::asset('assets/script/angular.js'))}}

<!--
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/nanoscroller.min.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/tether.min.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/config.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/util.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/jquery.emojiarea.js'))}}
{{HTML::script(URL::asset('assets/extension/emoji-picker/lib/js/emoji-picker.js'))}}
-->

{{HTML::script(URL::asset('assets/script/wysihtml5x-toolbar.min.js'))}}
{{HTML::script(URL::asset('assets/script/handlebars.runtime.min.js'))}}
{{HTML::script(URL::asset('assets/script/bootstrap3-wysihtml5.min.js'))}}

@stop

@section('content')

	<div class="container">

		<div class="col-md-8">

			<div class="page-header">
					@if ($task->type == 1)
						<span class="cw-heading-tag cw-reward-heading">REWARD</span>
					@elseif($task->type == 2)
						<span class="cw-heading-tag cw-bid-heading">BID</span>
					@endif

					<div class="pull-right" style="font-size: 25px; margin-top: -10px;">
						{{-- Edit Button --}}
						<div class="col-sm-6">
							@if (Auth::check() && $task->user_id == Auth::user()->id)
								<a class="fa fa-edit" id="edit" href="/task/{{$task->id}}/edit" data-toggle="tooltip" data-placement="top" title="Edit"></a>
							@endif
						</div>
						{{-- Favorite Button --}}
						<div class="col-sm-6">
							<a class="fa fa-heart-o favorite" id="favorite" data-toggle="tooltip" data-placement="top" title="favorite"></a>
							<span id="tip">favorite</span>
						</div>
					</div>

					<h3 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis" title="{{$task->title}}">
						{{$task->title}}
					</h3>
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

			<div class="col-sm-6">
				<h4><span>Task ID:</span> #{{$task->id}}</h4>
				@if ($task->type == 1)
					<h4>
						<span>Reward:</span>
						<span class="amount cw-text-red price">&yen; {{$task->amount}}</span>
					</h4>
				@elseif ($task->type == 2)
					<h4>
						<span>Budget:</span>
						<span class="amount cw-text-red price">&yen; {{$task->amount}}</span>
					</h4>
				@endif
			</div>

			<div class="col-sm-6">
				<h4><span>School location:</span>
				@if ($task->place == NULL)
					<span class="label label-danger">No School</span>
				@else
					{{-- {{Academy::get($task->user->school)->name}}</h4> --}}
					{{$school->name}}
				@endif
				{{-- <h4><span>Expiration:</span> {{$task->expiration}}</h4> --}}
				<h4>
					<span>Expiration:</span>
					@if ($task->state == 4)
						<span class="text-danger">Task End</span>
					@else
						<span data-toggle="tooltip" data-placement="bottom" title="{{ $task->expiration }}" id="expiration"></span>
					@endif
					<script>
						moment.lang('zh-cn');
						var strExpiration = "{{ $task->expiration }}";
						var expiration = new Date(strExpiration.replace(/-/g, "/"));
						var deltaSecond = expiration - new Date();
						$('#expiration').html(moment().add(deltaSecond).calendar());
					</script>
				</h4>
			</div>

			<div class="col-sm-12" ng-app>
				<ul class='task-procedure state' ng-controller="stateController">
					{{-- <span ng-bind="state"></span> --}}
					<li class="col-md-3" ng-class="{'light': state == 1, 'active': state == 1 || state == 2 || state == 3 || state == 4}">Enrollment</li>
					<li class="col-md-3" ng-class="{'light': state == 2, 'active': state == 2 || state == 3 || state == 4}">Performing</li>
					<li class="col-md-3" ng-class="{'light': state == 3, 'active': state == 3 || state == 4}">Check</li>
					<li class="col-md-3" ng-class="{'light': state == 4, 'active': state == 4}">Finish</li>
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
						<span id="countdown">
							countdown
						</span>
						<script>
							$('#countdown').countdown({until: expiration});
						</script>
					</div>
				@endif

				<h4><strong>Task Description:</strong></h4>
				<div class="detail" id="detail">
					{{str_limit($task->detail, 2000)}}
				</div>
				@if (mb_strlen($task->detail) > 2000)
					<div>
						<a href="javascript:;" id="more">
							More
							 ({{ round((mb_strlen($task->detail) - 2000) / mb_strlen($task->detail) * 100) }}%)
						</a>
					</div>
					<script>
					$('#more').click(function() {
						// alert($(this).html());
						$('#detail').html("{{$task->detail}}");
						if($(this).html() == 'Fold') {
							// alert('fold');
							$(this).html("More ({{ round((mb_strlen($task->detail) - 2000) / mb_strlen($task->detail) * 100) }}%)");
							$('#detail').html("{{str_limit($task->detail, 2000)}}");
						} else {
							$(this).html('Fold');
						}
					})
					</script>
				@endif

				<h4>
					@if (isset($commit_sum))
						<strong>
							Bidders
							<span data-toggle="tooltip" data-placement="top" title="{{count($task->bidder)}}人投稿">({{count($task->bidder)}}</span>
							/
							<span data-toggle="tooltip" data-placement="top" title="{{$commit_sum}}份投稿说明">{{$commit_sum}})</span>
						</strong>
					@elseif(isset($quote_sum))
						<strong>
							Bidders
							<span data-toggle="tooltip" data-placement="top" title="{{count($task->bidder)}}人报价">({{count($task->bidder)}}</span>
							/
							<span data-toggle="tooltip" data-placement="top" title="{{$quote_sum}}份报价说明">{{$quote_sum}})</span>
						</strong>

						@if (count($task->bidder) > 1)
							<span class="text-danger" style="margin-left: 30px;">
								Average Quote:
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
									committed at {{$task->winningQuote->latestCommit->first()->created_at}}
								</p>
								<div id="summary">
									{{$task->winningQuote->latestCommit->first()->summary}}
									@if ($task->user->id == Auth::user()->id && $task->state == 3)
										<a href="/pay/{{$task->winningQuote->latestCommit->first()->uuid}}" class="btn btn-success pull-right">Pay</a>
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
											committed at 
											{{$commit->created_at}}
										</span>

										@if ($task->winning_commit_id == $commit->id)
											<span class="label label-danger">
												<i class="fa fa-flag"></i>
												Win
											</span>
										@endif

										{{-- bid_btn --}}
										@if ($task->user->id == Auth::user()->id && $task->id != 4)
											<a href="/pay/{{$commit->uuid}}" class="btn btn-success pull-right">Pay</a>
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

										{{-- avatar --}}
										<a href="/user/{{$bidder->id}}">
											{{HTML::image(URL::asset('/avatar/' . $bidder->avatar ), '', ['class'=>'avatar-sm', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$bidder->username])}}
										</a>

										{{-- date --}}
										<span class="metadata">
											<a href="/user/{{$bidder->id}}"><strong>{{$bidder->username}}</strong></a>
											committed at 
											{{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->created_at}}
										</span>

										{{-- {{var_dump($task->winning_commit_id)}} --}}

										@if ($task->winning_commit_id == $bidder->findLatestCommitById($bidder->id, $task->id)->first()->id)
											<span class="label label-danger">
												<i class="fa fa-flag"></i>
												Win
											</span>
										@endif

										{{-- bid_btn --}}
										@if ($task->user->id == Auth::user()->id && $task->state != 4)
											<a href="/pay/{{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->uuid}}" class="btn btn-success pull-right">Pay</a>
										@endif

										<div id="summary">
											{{$bidder->findLatestCommitById($bidder->id, $task->id)->first()->summary}}
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
					@if (Auth::user()->realname())

						@if ($task->winningQuote != NULL && $task->winningQuote->user->id == Auth::user()->id)
							<p class="text-success">You are the best person the demander wanted, please commit your job soon!</p>
						@endif

						{{-- COMMIT AREA --}}
						@if (( ($task->type == 1 && $task->state == 1) || ($task->state == 2 || $task->state == 3) )  && $task->user->id != Auth::user()->id )


							{{Form::open(['url'=>"/task/$task_id/commit"])}}
								{{Form::label('summary', 'Summary')}}
								{{-- <div class="form-group emoji-picker-container">
									{{Form::textarea('summary', '', ['class'=>'form-control textarea-control textarea', 'placeholder'=>'Commit summary', 'data-emojiable'=>'true', 'rows'=>'5'])}}
								</div> --}}
								<div class="form-group">
									{{Form::textarea('summary', '', ['class'=>'form-control textarea', 'placeholder'=>'Commit summary'])}}
								</div>
								<div class="form-group">
									{{Form::submit('Commit', ['class'=>'btn btn-danger'])}}
								</div>
								{{Form::hidden('type', $task->type)}}
								@if ($task->winningCommit != NULL)
									{{Form::hidden('commit_id', $task->winningCommit->id)}}
								@elseif ($task->winningQuote != NULL)
									{{Form::hidden('quote_id', $task->winningQuote->id)}}
								@endif


							{{Form::close()}}
						@endif
						{{-- END COMMIT AREA --}}




						{{-- QUOTE AREA --}}
						@if ($task->type == 2 && $task->user->id != Auth::user()->id && $task->state == 1)

							{{Form::open(['url'=>"/task/$task_id/quote"])}}
								{{Form::label('price', '')}}
								{{Form::text('price', '', ['class'=>'form-control', 'placeholder'=>'Price'])}}
								{{Form::label('summary', 'Summary')}}
								<div class="form-group">
									{{Form::textarea('summary', '', ['class'=>'form-control', 'placeholder'=>'Quote summary'])}}
								</div>
								<div class="form-group">
									{{Form::submit('Quote', ['class'=>'btn btn-danger'])}}
								</div>
							{{Form::close()}}
						@endif
						{{-- END QUOTE AREA --}}


					@else


						@if ($task->user->id != Auth::user()->id && $task->state != 4)
							{{Form::open()}}
								{{Form::label('summary', 'Summary')}}
								<div class="form-group">
									{{Form::textarea('summary', '', ['class'=>'form-control', 'placeholder'=>'You are not allowed unless pass through realname authentication.', 'disabled'])}}
								</div>
								<div class="form-group">
									{{Form::submit('Quote', ['class'=>'btn btn-danger', 'disabled'])}}
								</div>
							{{Form::close()}}
						@endif



					@endif

				@else

					@if ($task->state != 4)
						{{Form::open()}}
							{{Form::label('summary', 'Commit')}}
							<div class="form-group">
								{{Form::textarea('summary', '', ['class'=>'form-control', 'placeholder'=>'You are not logined in', 'disabled'])}}
							</div>
							<div class="form-group">
								{{Form::submit('Quote', ['class'=>'btn btn-danger', 'disabled'])}}
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
					<span>Publisher: </span>
					<a data-toggle="tooltip" data-placement="top" title="View TA's profile" href="/user/{{$task->user->id}}">
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

				<p>Joined on {{explode(' ', $task->user->created_at)[0]}}</p>

				@if (strlen($task->user->tel))
					@if (Auth::check() && ( $task->user->realname() || Auth::user()->id == $task->user->id ) )
						<p><i class="fa fa-phone"></i> {{$task->user->tel}}</p>
					@else
						<p data-toggle="tooltip" data-placement="left" title="通过实名认证后可见"><i class="fa fa-phone"></i> {{$task->user->asteriskTel()}}</p>
					@endif
				@endif

				@if (strlen($task->user->qq))
					@if (Auth::check() && ( $task->user->realname() || Auth::user()->id == $task->user->id ) )
						<p><i class="fa fa-qq"></i> {{$task->user->qq}}</p>
					@else
						<p data-toggle="tooltip" data-placement="left" title="通过实名认证后可见"><i class="fa fa-qq"></i> {{$task->user->asteriskQQ()}}</p>
					@endif
				@endif

				@if (strlen($task->user->dorm))
					@if (Auth::check() && ( $task->user->realname() || Auth::user()->id == $task->user->id ) )
						@if ($task->user->dorm == 'no')
							<span class="label label-warning">Non-resident</span>
						@else
							<p><i class="fa fa-map-marker"></i> {{$task->user->dorm}}</p>
						@endif
					@else
						<p data-toggle="tooltip" data-placement="left" title="通过实名认证后可见"><i class="fa fa-map-marker"></i> {{$task->user->asteriskResident()}}</p>
					@endif
				@endif



			</div>
		</div>



			<div class="col-md-12">
				<div style="clear: both">
					@if ($prev_task != NULL)
						<div class="cw-pager"><a href="/task/{{$prev_task->id}}" class="text-info">
							<i class="fa fa-angle-up"></i>
							prev: {{$prev_task->title}}</a>
						</div>
					@else
						<div class="cw-pager"><span class="text-muted">
							<i class="fa fa-angle-up"></i>
							prev: none</span>
						</div>
					@endif
				</div>
				<div style="clear: both">
					@if ($next_task != NULL)
						<div class="cw-pager"><a href="/task/{{$next_task->id}}" class="text-info">
							<i class="fa fa-angle-down"></i>
							next: {{$next_task->title}}
						</a></div>
					@else
						<div class="cw-pager"><span class="text-muted">
							<i class="fa fa-angle-down"></i>
							next: none
						</span></div>
					@endif
				</div>
			</div>
			



	</div>

	<script>
		$(function() {
			$('.textarea').wysihtml5({
				toolbar: {
					fa: true,
				}
			});
		});
	</script>

@stop