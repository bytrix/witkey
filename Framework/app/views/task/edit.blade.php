@extends('layout.task')

@section('menu')
	<ul class="nav navbar-nav">

	<li><a href="/">Home</a></li>
	<li><a href="/task/new">Publish Task</a></li>
	<li class="active"><a href="/task/list">Task List</a></li>
	<li class="dropdown">
	  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	    <li><a href="/about">About</a></li>
	    {{-- <li><a href="/contact">Contact</a></li> --}}
	  </ul>
	</li>

	</ul>

@stop

@section('style')

<style>
#editor {
	overflow:scroll;
	max-height:300px;
}
</style>

{{HTML::style(URL::asset('assets/style/font-awesome.min.css'))}}
{{HTML::style(URL::asset('assets/style/bootstrap3-wysihtml5.min.css'))}}

{{HTML::script(URL::asset('assets/script/wysihtml5x-toolbar.min.js'))}}
{{HTML::script(URL::asset('assets/script/handlebars.runtime.min.js'))}}
{{HTML::script(URL::asset('assets/script/bootstrap3-wysihtml5.min.js'))}}

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
		<h1 class="page-header">Edit task <small>Task ID #{{$task->id}}</small></h1>
		{{Form::open(['class'=>'form-custom'])}}
			<div class="form-group">
				{{Form::label('title', 'Title', ['class'=>'control-label'])}}
				{{Form::text('title', $task->title, ['placeholder'=>'Title', 'class'=>'form-control'])}}
			</div>
			<div class="form-group">
				{{Form::label('detail', 'Detail', ['class'=>'control-label'])}}
				{{Form::textarea('detail', $task->detail, ['placeholder'=>'Detail', 'class'=>'form-control textarea', 'rows'=>'20'])}}


{{-- 
      <textarea class="textarea form-control" placeholder="Enter text ..."></textarea>
 --}}

			</div>
			<div class="form-group">
				{{Form::submit('Save', ['class'=>'btn btn-primary'])}}
				{{-- {{HTML::link('task/new/set-reward', 'Next', ['class'=>'btn btn-primary'])}} --}}
			</div>






	<script>
  $('.textarea').wysihtml5({
    toolbar: {
      fa: true
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