@extends('task.publish.master')

@section('style')

<style>
#editor {
	overflow:scroll;
	/*max-height:300px;*/
}
</style>

{{HTML::style(URL::asset('assets/style/bootstrap3-wysihtml5.min.css'))}}


@stop

@section('script')
	{{HTML::script(URL::asset('assets/script/wysihtml5x-toolbar.min.js'))}}
	{{HTML::script(URL::asset('assets/script/handlebars.runtime.min.js'))}}
	{{HTML::script(URL::asset('assets/script/bootstrap3-wysihtml5.min.js'))}}
@stop

@section('content')
	<div class="container">

		<h1 class="page-header">Publish you task</h1>
		<ul class='task-procedure first'>
			<li class="first col-md-4">CREATE TASK</li>
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
				{{Form::submit('Next', ['class'=>'btn btn-primary'])}}
			</div>

		<script>
			$('.textarea').wysihtml5({
				toolbar: {
					fa: true,
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