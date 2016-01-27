@extends('layout.master')

@section('menu')
  <ul class="nav navbar-nav">
    {{-- <li><a href="/">Home</a></li> --}}
    <li><a href="/school/{{Session::get('school_id_session')}}">{{Lang::get('task.list')}}</a></li>
    <li><a href="/task/create">{{Lang::get('task.task-publish')}}</a></li>
    <li class="dropdown">
      <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Lang::get('message.help')}} <span class="caret"></span></a>
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
    .send{
      margin-top: 40px;
    }
    .from_user{
      width: 80px;
      display: inline-block;
    }
    .tooltip{
      white-space: nowrap;
    }
    .messageTitle{
      max-width: 580px;
      display: inline-block;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  </style>
@stop

@section('script')
{{-- @parent --}}
  {{HTML::script(URL::asset('assets/script/moment.js'))}}
  {{HTML::script(URL::asset('assets/script/moment-with-locales.min.js'))}}
  <script>
  moment.lang('zh-cn');
  </script>
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