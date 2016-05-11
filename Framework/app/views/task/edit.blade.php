@extends('task.master')

@section('style')
@parent
<style>
#editor {
	overflow:scroll;
	max-height:300px;
}
</style>

{{HTML::style(URL::asset('assets/style/font-awesome.min.css'))}}
{{-- {{HTML::style(URL::asset('assets/style/bootstrap3-wysihtml5.min.css'))}} --}}
{{HTML::style(URL::asset('assets/style/simditor.css'))}}

{{-- {{HTML::script(URL::asset('assets/script/wysihtml5x-toolbar.min.js'))}} --}}
{{-- {{HTML::script(URL::asset('assets/script/handlebars.runtime.min.js'))}} --}}
{{-- {{HTML::script(URL::asset('assets/script/bootstrap3-wysihtml5.min.js'))}} --}}
{{HTML::script(URL::asset('assets/script/module.js'))}}
{{HTML::script(URL::asset('assets/script/hotkeys.js'))}}
{{ HTML::script(URL::asset('assets/script/uploader.js')) }}
{{HTML::script(URL::asset('assets/script/simditor.js'))}}


@stop


@section('content')
{{-- 	<div class="container">
		<ul class='task-procedure first'>
			<li class="first col-md-4">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div> --}}
	<div class="container">
		<h1 class="page-header">
			{{Lang::get('task.edit-task')}}
			{{-- <small>Task ID #{{$task->id}}</small> --}}
		</h1>
		{{Form::open(['class'=>'form-custom'])}}
			<div class="form-group">
				{{Form::label('title', Lang::get('task.title'), ['class'=>'control-label'])}}
				{{Form::text('title', $task->title, ['placeholder'=>Lang::get('task.title'), 'class'=>'form-control'])}}
			</div>
			<div class="form-group">
				{{Form::label('detail', Lang::get('task.detail'), ['class'=>'control-label'])}}
				{{Form::textarea('detail', $task->detail, ['id'=>'editor', 'placeholder'=>Lang::get('task.detail'), 'class'=>'form-control textarea', 'rows'=>'14'])}}


{{-- 
      <textarea class="textarea form-control" placeholder="Enter text ..."></textarea>
 --}}

			</div>
			<div class="form-group">
				{{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary'])}}
				{{HTML::link("task/$task->id", Lang::get('message.cancel'), ['class'=>'btn btn-default'])}}
			</div>






	<script>
  // $('.textarea').wysihtml5({
  //   toolbar: {
  //     fa: true
  //   }
  // });
		var editor = new Simditor({
			textarea: '#editor',
			upload: {
				url : '/task/create/uploadImage', //文件上传的接口地址
				params: null, //键值对,指定文件上传接口的额外参数,上传的时候随文件一起提交
				fileKey: 'fileData', //服务器端获取文件数据的参数名
				connectionCount: 3,
				leaveConfirm: '正在上传文件'
			}
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