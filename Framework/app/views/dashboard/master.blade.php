@extends('layout.home')

@section('menu')
  <ul class="nav navbar-nav">
    <li><a href="/">Home</a></li>
    <li><a href="/task/list">Task List</a></li>
    <li><a href="/task/create">Publish Task</a></li>
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
  {{HTML::style('assets/style/dashboard.css')}}
  <style>
  	.avartar-md{
  		width: 120px;
  	}
  	.greeting{
  		/*background-color: red;*/
  	}
    .idcard_image{
      width: 300px;
      height: 200px;
    }
  </style>
@stop

@section('content')

    <div class="container-fluid" ng-app="academyApp">
      <div class="row">

        @yield('control-panel')

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          @yield('user-panel')
        </div>

      </div>
    </div>

@stop