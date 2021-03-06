@extends('layout.master')

@section('menu')
	<ul class="nav navbar-nav">
		{{-- <li><a href="/">Home</a></li> --}}
		<li class="active"><a href="/school/{{Session::get('school_id_session')}}">{{Lang::get('task.list')}}</a></li>
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
	<style>
		.cw-circle-paid,
		.cw-circle-unpaid{
			margin-right: 6px;
			margin-top: 3px;
		}
		.cw-circle-paid{
			color: rgb(255, 224, 9);
		}
		.cw-circle-unpaid{
			color: #ddd;
		}
		.simditor-body img{
		max-width: 800px;
		}
	</style>
@stop

@section('procedure-style')
	{{HTML::style('assets/style/task-procedure.css')}}
@stop
