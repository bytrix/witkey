@extends('layout.master')

@section('menu')
	<ul class="nav navbar-nav">
		{{-- <li><a href="/">Home</a></li> --}}
		<li><a href="/school/{{Session::get('school_id_session')}}">{{Lang::get('task.list')}}</a></li>
		<li><a href="/task/create">{{Lang::get('task.task-publish')}}</a></li>
		<li><a href="/help">{{Lang::get('message.help')}}</a></li>
{{-- 		<li class="dropdown">
		  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Lang::get('message.help')}} <span class="caret"></span></a>
		  <ul class="dropdown-menu">
		    <li><a href="/help">About</a></li>
		  </ul>
		</li> --}}

	</ul>
@stop

@section('style')
@parent
@stop

{{-- @section('procedure-style')
	{{HTML::style('assets/style/task-procedure.css')}}
@stop
 --}}