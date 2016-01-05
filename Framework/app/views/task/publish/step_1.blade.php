@extends('task.publish.master')

@section('style')

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
	<div class="container">

		<h1 class="page-header">Publish you task</h1>
		<ul class='task-procedure first state'>
			<li class="first col-md-4 light">CREATE TASK</li>
			<li class="second col-md-4">SET REWARD</li>
			<li class="third col-md-4">PUBLISH</li>
		</ul>
	</div>
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
							<i class="glyphicon glyphicon-open-file"></i>
							<input type="file" id="uploader">
							Upload File
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				{{Form::submit('Next', ['class'=>'btn btn-primary'])}}
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