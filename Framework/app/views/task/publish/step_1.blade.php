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
	{{HTML::style(URL::asset('assets/style/bootstrap3-wysihtml5.min.css'))}}
	{{HTML::style(URL::asset('assets/style/jquery.fileupload.css'))}}
@stop

@section('script')
	{{HTML::script(URL::asset('assets/script/wysihtml5x-toolbar.min.js'))}}
	{{HTML::script(URL::asset('assets/script/handlebars.runtime.min.js'))}}
	{{HTML::script(URL::asset('assets/script/bootstrap3-wysihtml5.min.js'))}}
	{{HTML::script(URL::asset('assets/script/vendor/jquery.ui.widget.js'))}}
	{{HTML::script(URL::asset('assets/script/jquery.fileupload.js'))}}
	{{HTML::script(URL::asset('assets/script/bootstrap-form-buttonset.js'))}}

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
		Publish your task
	@stop
	
	@section('task-procedure')
		<ul class='task-procedure first state'>
			<li class="first col-md-4 light">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	@stop

	<div class="container">
		{{Form::open(['url'=>'task/create/step-2', 'method'=>'post', 'class'=>'form-custom'])}}
			@if ($hired_user != NULL)
				{{Form::hidden('hire', $hired_user->id)}}
				<p class="alert alert-success">
					<a href="/task/create/" class="close" data-toggle="tooltip" data-placement="top" title="Not hire">&times;</a>
					You are hiring <a href="javascript:;" class="alert-link" id="postcard">{{$hired_user->username}}</a>, please complete your task description
				</p>
			@endif
			<div class="form-group">
				{{Form::label('title', 'Title', ['class'=>'control-label'])}}
				{{Form::text('title', Session::get('title'), ['placeholder'=>'Title', 'class'=>'form-control'])}}
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
				{{Form::label('detail', 'Detail', ['class'=>'control-label'])}}
				{{Form::textarea('detail', Session::get('detail'), ['placeholder'=>'Detail', 'class'=>'form-control textarea', 'rows'=>'14'])}}
			</div>

			<div class="form-group">
				<div class="row clearfix">
					<div class="col-md-10">
						<span id="filedata">Upload File</span>
						<div class="progress">
							<div class="progress-bar progress-bar-striped active" style="width: 0%" id="progress-bar"></div>
						</div>
					</div>
					<div class="col-md-2">
						<span class="btn btn-primary fileinput-button" style="margin-top: 10px;">
							{{-- <i class="glyphicon glyphicon-open-file"></i> --}}
							<i class="fa fa-plus"></i>
							<input type="file" id="uploader">
							Attach File
						</span>
						{{Form::hidden('file_name', '', ['id'=>'file_name'])}}
					</div>
				</div>
			</div>

			<div class="form-group">
				{{-- {{Form::submit('Next', ['class'=>'btn btn-primary'])}} --}}
				<button type="submit" class="btn btn-primary">
					Next
					<i class="fa fa-angle-double-right"></i>
				</button>
			</div>

		<script>
		$(function() {
			$('select').select2({
				theme: "bootstrap"
			});
			$('.textarea').wysihtml5({
				toolbar: {
					fa: true,
				}
			});
			$('#uploader').fileupload({
				url: '/upload',
				progress: function(e, data) {
					var percent = parseInt((data.loaded / data.total) * 100);
					console.log(percent);
					$('#progress-bar').attr('style', 'width: ' + percent + '%');
					$('#filedata').text(percent + "%");
				},
				done: function(e, data) {
					console.log('done');
					console.log(data);
					$('#filedata').html("<a href='/upload/cache/" + data.files[0].name + "'>" + data.files[0].name + "</a>" + " uploaded!");
					$('#file_name').attr('value', data.files[0].name);
				}
			});
		})
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