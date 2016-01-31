@extends('layout.master')

@section('menu')
	<ul class="nav navbar-nav">
		{{-- <li><a href="/">Home</a></li> --}}
		<li><a href="/school/{{Session::get('school_id_session')}}">{{Lang::get('task.list')}}</a></li>
		<li class="active"><a href="/task/create">{{Lang::get('task.task-publish')}}</a></li>
    <li><a href="/about">{{Lang::get('message.help')}}</a></li>
{{-- 		<li class="dropdown">
		  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Lang::get('message.help')}} <span class="caret"></span></a>
		  <ul class="dropdown-menu">
		    <li><a href="/about">About</a></li>
		  </ul>
		</li>
 --}}
	</ul>

@stop

@section('style')
	{{HTML::style('assets/style/task-procedure.css')}}
  <style>
  img{
    max-width: 800px;
  }
  </style>
@stop
{{-- 
@section('procedure-style')
	{{HTML::style('assets/style/task-procedure.css')}}
@stop
 --}}

@section('content')
	<div class="container">
		<h1 class="page-header">
			@yield('header')

            @if ($mySchool != NULL)
              <small class="pull-right school-select-wrap">
                {{Lang::get('message.school')}}:
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
            @else
              <small class="pull-right school-select-wrap">
                {{Lang::get('message.school')}}:
                <div class="dropdown pull-right">
                  <a href="javascript:;" class="link school-select" data-toggle="dropdown">{{Lang::get('message.select-school')}}</a>
                  <ul class="dropdown-menu">
                    @foreach ($schools as $school)
                      <li><a href="/school/{{$school->id}}">
                        {{$school->name}}
                      </a></li>
                    @endforeach
                  </ul>
                </div>
              </small>
            @endif

		</h1>
		@yield('task-procedure')
	</div>
@stop