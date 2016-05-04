@extends('task.publish.master')

@section('style')
@parent
<style>
/*	#editor {
		overflow:scroll;
	}*/
	.wysihtml5-toolbar a{
		text-shadow: none;
	}
	.my-container button{
		text-shadow: none;
	}
	</style>
	{{-- {{HTML::style(URL::asset('assets/style/bootstrap3-wysihtml5.min.css'))}} --}}
	{{HTML::style(URL::asset('assets/style/jquery.fileupload.css'))}}


	{{-- <link rel="stylesheet" href="http://simditor.tower.im/assets/styles/simditor.css"> --}}
	{{HTML::style(URL::asset('assets/style/simditor.css'))}}
	{{-- {{HTML::style('https://github.com/mycolorway/simditor-emoji/raw/master/styles/simditor-emoji.css')}} --}}
	{{HTML::style('assets/style/simditor-emoji.css')}}

@stop

@section('script')
	{{-- {{HTML::script(URL::asset('assets/script/wysihtml5x-toolbar.min.js'))}} --}}
	{{-- {{HTML::script(URL::asset('assets/script/handlebars.runtime.min.js'))}} --}}
	{{-- {{HTML::script(URL::asset('assets/script/bootstrap3-wysihtml5.min.js'))}} --}}
	{{-- {{HTML::script(URL::asset('assets/script/bootstrap-wysihtml5.zh-CN.js'))}} --}}
	{{-- {{HTML::script(URL::asset('assets/script/bootstrap3-wysihtml5.js'))}} --}}
	{{HTML::script(URL::asset('assets/script/vendor/jquery.ui.widget.js'))}}
	{{HTML::script(URL::asset('assets/script/jquery.fileupload.js'))}}
	{{HTML::script(URL::asset('assets/script/bootstrap-form-buttonset.js'))}}


{{-- 	// <script src="http://simditor.tower.im/assets/scripts/module.js"></script>
	// <script src="http://simditor.tower.im/assets/scripts/hotkeys.js"></script>
	// <script src="http://simditor.tower.im/assets/scripts/simditor.js"></script> --}}

	{{HTML::script(URL::asset('assets/script/module.js'))}}
	{{ HTML::script(URL::asset('assets/script/uploader.js')) }}
	{{HTML::script(URL::asset('assets/script/hotkeys.js'))}}
	{{HTML::script(URL::asset('assets/script/simditor.js'))}}
	{{-- {{HTML::script('https://github.com/mycolorway/simditor-emoji/raw/master/lib/simditor-emoji.js')}} --}}
	{{HTML::script('assets/script/simditor-emoji.js')}}


	@if ($hired_user != NULL)
		<script>
		$(function() {
			$('#postcard').popover({
				placement: 'top',
				content: '<img src="/avatar/{{$hired_user->avatar}}" class="avatar-md"><h4>{{$hired_user->username}}</h4><p>{{$hired_user->email}}</p>',
				html: true,
			})
			.on("mouseenter", function() {
				// console.log('mouse enter');
				$(this).popover("show");
			})
			.on("mouseleave", function() {
				// console.log('mouse leave');
				$(this).popover("hide");
			})
		});
		</script>
	@endif
@stop

@section('content')
@parent
{{-- 	<div class="container">

		<h1 class="page-header">
			Publish you task
			
          <small class="pull-right school-select-wrap">
            School:
            <div class="dropdown pull-right">
              <a href="javascript:;" class="link school-select" data-toggle="dropdown">{{$mySchool->name}}</a>
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

		</h1>
		<ul class='task-procedure first state'>
			<li class="first col-md-4 light">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div> --}}
	@section('header')
		{{Lang::get('task.create-task')}}
	@stop
	
	@section('task-procedure')
		<ul class='task-procedure first state'>
			<li class="first col-md-4 light">{{Lang::get('task.create-task')}}</li>
			<li class="second col-md-4">{{Lang::get('task.set-reward')}}</li>
			<li class="third col-md-4">{{Lang::get('task.task-publish')}}</li>
		</ul>
	@stop

	<div class="container">

<pre>
{{ var_dump(Session::get('task')) }}
</pre>


		{{Form::open(['url'=>'task/create/step-2', 'method'=>'post', 'class'=>'form-custom', 'files'=>true])}}

			@if ($hired_user != NULL)
				{{Form::hidden('hire', $hired_user->id)}}
				<p class="alert alert-success">
					<a href="/task/create/" class="close" data-toggle="tooltip" data-placement="top" title="Not hire">&times;</a>
					You are hiring <a href="javascript:;" class="alert-link" id="postcard">{{$hired_user->username}}</a>, please complete your task description
				</p>
			@endif

			@if (Auth::user()->dorm == '')
				<p class="alert alert-danger">
					<span class="close" data-dismiss="alert">&times;</span>
					您的宿舍地址尚未填写，可能导致威客无法联系到您，
					<a href="/dashboard/myProfile" class="alert-link">立即填写</a>
				</p>
			@endif

			@if (Auth::user()->authenticated != 2)
				<div class="form-group">
					<p class="alert alert-danger">
						<span class="close" data-dismiss="alert">&times;</span>
						您尚未通过实名认证，请通过
						<a class="alert-link" href="/dashboard/authentication">实名认证</a>
						后继续发布任务
					</p>
				</div>
			@endif
			<div class="form-group">
				{{Form::label('title', Lang::get('task.title'), ['class'=>'control-label'])}}
				{{Form::text('title', $task['title'], ['placeholder'=>Lang::get('task.title'), 'class'=>'form-control'])}}
				<p style="margin-top: 8px; margin-left: 18px;">
					<a class="link" href="manual" target="_blank" style="border-bottom: 1px dashed #888;">
						<b>
							<i class="fa fa-question-circle"></i>
							{{ Lang::get('task.how-to-publish-a-qualified-task') }}
							（发布任务前请认真阅读该链接）
						</b>
					</a>
				</p>
			</div>

			<div class="form-group row">

{{-- 				<div class="my-container">
					@foreach ($categories as $category)
						{{Form::radio('category_id', $category->id, Session::get('category_id')==$category->id, ['id'=>$category->name])}}
						<label for="{{$category->name}}">{{$category->name}}</label>
					@endforeach
				</div>
				<script>
				$('.my-container').bsFormButtonset('attach');
				</script>
 --}}
{{--  				<div class="col-md-6">
					<select name="category" id="" class="form-control">
						<option></option>
						@foreach ($categories as $category)
							<option value="">{{$category->name}}</option>
						@endforeach
					</select>
 				</div>
 				<div class="col-md-6">
					<select name="hire" id="" class="form-control">
						<option></option>
						@foreach ($friends as $friend)
							<option value="">{{$friend->username}}</option>
						@endforeach
					</select>
 				</div> --}}
			</div>

			<div class="form-group">
				{{Form::label('detail', Lang::get('task.detail'), ['class'=>'control-label'])}}
				{{Form::textarea('detail', $task['detail'], ['id'=>'editor', 'placeholder'=>Lang::get('task.detail'), 'class'=>'form-control textarea', 'rows'=>'14', 'autofocus'=>'autofocus'])}}
			</div>

			<div class="form-group">
				<div class="row clearfix">
					<div class="col-md-10">
						{{Form::label('upload-attachment', Lang::get('task.upload-attachment'), ['class'=>'control-label'])}}
						<div class="progress">
							<div class="progress-bar progress-bar-striped active" style="width: 0%" id="progress-bar"></div>
						</div>
						<span id="filedata"></span>
					</div>
					<div class="col-md-2">
						<span class="btn btn-primary fileinput-button" style="margin-top: 10px;">
							{{-- <i class="glyphicon glyphicon-open-file"></i> --}}
							<i class="fa fa-plus"></i>
							<input type="file" id="uploader">
							{{Lang::get('task.attach-file')}}
						</span>
						{{Form::hidden('file_name', '', ['id'=>'file_name'])}}
					</div>
				</div>
			</div>

			<div class="form-group">
				{{-- {{Form::submit('Next', ['class'=>'btn btn-primary'])}} --}}
				@if (Auth::user()->authenticated != 2)
					<button type="submit" class="btn btn-primary" disabled="disabled">
				@else
					<button type="submit" class="btn btn-primary">
				@endif
					{{Lang::get('task.next')}}
					<i class="fa fa-angle-double-right"></i>
				</button>
			</div>

		<script>
		$(function() {
			// $('select').select2({
			// 	theme: "bootstrap"
			// });
			// $('.textarea').wysihtml5({
			// 	toolbar: {
			// 		fa: true,
			// 		locale: "zh-CN",
			// 	}
			// });
			var editor = new Simditor({
				textarea: $('#editor'),
				toolbar: ['bold', 'italic', 'underline', 'strikethrough', 'ol', 'ul', 'blockquote', 'code', 'link', 'image', 'indent', 'outdent', 'emoji'],
				// toolbar: ['emoji'],
				emoji: {
					imagePath: "/assets/image/emoji/"
				},
				// defaultImage: '',
				pasteImage: true,
				upload: {
					url : '/task/create/uploadImage', //文件上传的接口地址
					params: null, //键值对,指定文件上传接口的额外参数,上传的时候随文件一起提交
					fileKey: 'fileData', //服务器端获取文件数据的参数名
					connectionCount: 3,
					leaveConfirm: '正在上传文件'
				}
			});
			$('#uploader').fileupload({
				url: '/upload/',
				progress: function(e, data) {
					var percent = parseInt((data.loaded / data.total) * 100);
					// console.log(percent);
					$('#progress-bar').attr('style', 'width: ' + percent + '%');
					$('#filedata').text(percent + "%");
				},
				done: function(e, data) {
					// console.log('done');
					console.log(data);
					$('#filedata').html("<a href='/upload/cache/" + data.files[0].name + "'>" + data.files[0].name + "</a>" + " 上传成功！");
					$('#file_name').attr('value', data.files[0].name);
				}
			});

			$('form').submit(function() {
				@if (Auth::user()->authenticated != 2)
					return false;
				@endif
			});
		});
		</script>

		{{Form::close()}}

		

		@if (count($errors->all()))
			<div class="alert alert-danger">
				@foreach ($errors->all() as $error)
					<p>{{$error}}</p>
				@endforeach
			</div>
		@endif
		
	</div>
@stop