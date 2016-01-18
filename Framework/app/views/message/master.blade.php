@extends('layout.master')

@section('menu')
  <ul class="nav navbar-nav">
    {{-- <li><a href="/">Home</a></li> --}}
    <li><a href="/school/{{Session::get('school_id_session')}}">Task List</a></li>
    <li><a href="/task/create">Publish Task</a></li>
    <li class="dropdown">
      <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="/about">About</a></li>
        {{-- <li><a href="/about">About</a></li> --}}
        {{-- <li><a href="/contact">Contact</a></li> --}}
      </ul>
    </li>

  </ul>
@stop

@section('style')
@parent
  <style>
    .unread{
      font-weight: bold;
    }
  </style>
@stop

@section('content')
  <div class="container">
    <div class="col-md-3">
      @yield('nav')
    </div>
    <div class="col-md-8">
      @yield('message-board')
    </div>
  </div>
@stop

@section('style')
  <style>
    .count{
      float: right;
      font-weight: bold;
    }
  </style>
@stop