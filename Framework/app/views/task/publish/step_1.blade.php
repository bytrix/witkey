@extends('task.publish.master')

@section('style')
@parent
<style>
	#editor {
		overflow:scroll;
		/*max-height:300px;*/
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
			<div class="form-group">
				{{Form::label('title', 'Title', ['class'=>'control-label'])}}
				{{Form::text('title', Session::get('title'), ['placeholder'=>'Title', 'class'=>'form-control'])}}
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
					$('#filedata').text(data.files[0].name + " uploaded!");
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