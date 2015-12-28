@extends('task.master')

@section('style')
@parent
<style>
	.avatar-sm{
		cursor: pointer;
		width: 30px;
		margin-right: 12px;
		margin-bottom: 4px;
	}
	.avatar-sm:hover{
		box-shadow: 0 0 2px #337ab7;
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
	#edit{
		font-size: 0.8em;
		cursor: pointer;
		color: #666;
		margin-left: 0.6em;
		margin-right: 0.7em;
	}
	#edit:hover{
		color: #333;
	}
	.favorite{
		cursor: pointer;
		font-size: 0.8em;
		margin-top: 0.3em;
		margin-right: 1.7em;
		color: red;
	}

	#tip{
		display: block;
		margin-left: -20px;
		position: absolute;
		color: red;
		font-size: 12px;
		width: 60px;
		text-align: center;
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
				<h3>
					@if ($task->type == 1)
						<span class="label label-warning">REWARD</span>
					@elseif($task->type == 2)
						<span class="label label-danger">BID</span>
					@endif
					@if (strlen($task->title) > 40)
						<span title="{{$task->title}}" class="detail-title">
							{{str_limit($task->title, 40)}}
						</span>
					@else
						{{$task->title}}
					@endif
					<div class="pull-right">
						{{-- Edit Button --}}
						<div class="col-sm-6">
							@if (Auth::check())
								@if ($task->user_id == Auth::user()->id)
									<i class="fa fa-edit" id="edit" href="/task/{{$task->id}}/edit" data-toggle="tooltip" data-placement="top" title="Edit"></i>
								@endif
							@endif
						</div>
						<div class="col-sm-6">
							{{-- Favorite Button --}}
							<i class="fa fa-heart-o favorite" id="favorite" data-toggle="tooltip" data-placement="top" title="favorite"></i>
							<span id="tip">favorite</span>
						</div>
					</div>
				</h3>
				<script>

				$('#favorite').click(function() {
					$.ajax({
						type: 'post',
						url: '/api/markFavoriteTask/'+{{$task_id}},
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
				<h4><strong>Task ID:</strong> #{{$task->id}}</h4>
				@if ($task->type == 1)
					<h4>
						<strong>Reward:</strong>
						<span class="amount text-success">&yen;{{$task->amount}}</span>
					</h4>
				@elseif ($task->type == 2)
					<h4>
						<strong>Budget:</strong>
						<span class="amount text-success">&yen;{{$task->amount}}</span>
					</h4>
				@endif
			</div>

			<div class="col-sm-6">
				<h4><strong>School location:</strong>
				@if ($task->user->school == NULL)
					<span class="label label-danger">No School</span>
				@else
					{{Academy::getAcademy($task->user->school)}}</h4>
				@endif
				{{-- <h4><strong>Expiration:</strong> {{$task->expiration}}</h4> --}}
				<h4>
					<strong>Expiration:</strong>
					<span data-toggle="tooltip" data-placement="bottom" title="{{ $task->expiration }}" id="expiration"></span>
					<script>
					moment.lang('zh-cn');
					var expiration = new Date("{{ $task->expiration }}");
					var deltaSecond = expiration - new Date();
					$('#expiration').html(moment().add(deltaSecond).calendar());
					</script>
				</h4>
				<p></p>
			</div>

			<div class="col-sm-12">

				<ul class='task-procedure first'>
					<li class="first col-md-3">Enrollment</li>
					<li class="second col-md-3">Carry out</li>
					<li class="third col-md-3">Check</li>
					<li class="third col-md-3">Finish</li>
				</ul>
				
				<div class="time">
					距离任务结束时间：
					<span id="countdown">
						countdown
					</span>
					<script>
						var expiration = new Date("{{ $task->expiration }}");
						$('#countdown').countdown({until: expiration});
					</script>
				</div>


				<h4><strong>Task Description:</strong></h4>
				<div class="detail" id="detail">
					{{str_limit($task->detail, 1200)}}
				</div>
				@if (strlen($task->detail) > 1200)
					<div>
						<a href="javascript:;" id="more">More</a>
					</div>
					<script>
					$('#more').click(function() {
						// alert($(this).html());
						$('#detail').html("{{$task->detail}}");
						if($(this).html() == 'Fold') {
							// alert('fold');
							$(this).html('More');
							$('#detail').html("{{str_limit($task->detail, 1200)}}");
						} else {
							$(this).html('Fold');
						}
					})
					</script>
				@endif

				<h4>
					<strong>
						Bidders
						<span data-toggle="tooltip" data-placement="top" title="人数">({{count($task->bidder)}}</span>
						/
						<span data-toggle="tooltip" data-placement="top" title="交稿数">{{$commit_sum}})</span>
					</strong>
				</h4>
				<div class="avatar-bar">
					@foreach ($task->bidder as $bidder)
						<img class='avatar-sm' onclick="window.location.href='/user/{{$bidder->id}}'" src="{{URL::asset('/avatar/' . $bidder->avatar )}}" data-toggle="tooltip" title="{{$bidder->username}}" data-placement="top">

					@endforeach
				</div>


				@if (Auth::check())


					<div class="list-group">

						@if (isset($commits))
							
							@foreach ($commits as $commit)
								<div class="list-group-item">

									{{-- no --}}
									<span class="no"># {{$commit->id}}</span>

									{{-- avatar --}}
									<a href="/">
										{{HTML::image(URL::asset('/avatar/' . $commit->user->avatar ), '', ['class'=>'avatar-sm', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$commit->user->username])}}
									</a>

									{{-- date --}}
									<span class="metadata">
										<a href="/"><strong>{{$commit->user->username}}</strong></a>
										committed at 
										{{$commit->created_at}}
									</span>

									{{-- bid_btn --}}
									<a href="javascript:;" class="btn btn-danger pull-right">Bid</a>

									<div id="summary">
										{{$commit->summary}}
									</div>
								</div>
							@endforeach

							{{$commits->links()}}


						@elseif(isset($quotes))

							@foreach ($quotes as $quote)
								<div class="list-group-item">
									{{$quote->user->username}} {{$quote->summary}}
								</div>
							@endforeach

						@endif

					</div>




					@if (Auth::user()->realname())

						{{-- COMMIT AREA --}}
						@if ($task->type == 1 && $task->user->id != Auth::user()->id)
							{{Form::open(['url'=>"/task/$task_id/commit"])}}

								{{Form::label('summary', 'Commit')}}

								{{-- <div class="form-group emoji-picker-container">
									{{Form::textarea('summary', '', ['class'=>'form-control textarea-control textarea', 'placeholder'=>'Commit summary', 'data-emojiable'=>'true', 'rows'=>'5'])}}
								</div> --}}
								<div class="form-group">
									{{Form::textarea('summary', '', ['class'=>'form-control textarea', 'placeholder'=>'Commit summary'])}}
								</div>
								<div class="form-group">
									{{Form::submit('Commit', ['class'=>'btn btn-danger'])}}
								</div>


							{{Form::close()}}
						@endif
						{{-- END COMMIT AREA --}}




						{{-- QUOTE AREA --}}
						@if ($task->type == 2 && $task->user->id != Auth::user()->id)
							{{Form::open(['url'=>"/task/$task_id/quote"])}}
								{{Form::label('summary', 'Commit')}}
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


						@if ($task->user->id != Auth::user()->id)
							{{Form::open()}}
								{{Form::label('summary', 'Commit')}}
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
					<img src="{{URL::asset('/avatar/' . $task->user->avatar )}}" class="thumbnail">
				</div>
				<h4><a href="/user/{{$task->user->id}}">{{$task->user->username}}</a></h4>

				<span>
					{{-- <img src="{{URL::asset('assets/image')}}{{$task->user->gender == 'M' ? '/iconfont-genderman.png' : '/iconfont-genderwoman.png' }}"> --}}
					@if ($task->user->gender == 'M')
						<i class="fa fa-mars"></i>
					@elseif($task->user->gender == 'F')
						<i class="fa fa-venus"></i>
					@endif
				</span>
				<p>Joined on {{explode(' ', $task->user->created_at)[0]}}</p>

				@if (strlen($task->user->tel))
					@if (Auth::check() && $task->user->realname())
						<p><i class="fa fa-phone"></i> {{$task->user->tel}}</p>
					@else
						<p data-toggle="tooltip" data-placement="left" title="通过实名认证后可见"><i class="fa fa-phone"></i> {{$task->user->asteriskTel()}}</p>
					@endif
				@endif

				@if (strlen($task->user->qq))
					@if (Auth::check() && $task->user->realname())
						<p><i class="fa fa-qq"></i> {{$task->user->qq}}</p>
					@else
						<p data-toggle="tooltip" data-placement="left" title="通过实名认证后可见"><i class="fa fa-qq"></i> {{$task->user->asteriskQQ()}}</p>
					@endif
				@endif

				@if (strlen($task->user->dorm))
					@if (Auth::check() && $task->user->realname())
						@if ($task->user->dorm == 'no')
							<span class="label label-warning">Non-resident</span>
						@else
							<p><i class="fa fa-map-marker"></i> {{$task->user->dorm}}</p>
						@endif
					@else
						<p data-toggle="tooltip" data-placement="left" title="通过实名认证后可见"><i class="fa fa-map-marker"></i> {{$task->user->asteriskDorm()}}</p>
					@endif
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