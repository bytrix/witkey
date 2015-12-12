@extends('layout.default')

@section('menu')
	<ul class="nav navbar-nav">

	<li class="active"><a href="/">Home</a></li>
	<li><a href="/task/new">Publish Task</a></li>
	<li><a href="/task/list">Task List</a></li>
	<li class="dropdown">
	  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	    <li><a href="/about">About</a></li>
	    {{-- <li><a href="/contact">Contact</a></li> --}}
	  </ul>
	</li>
	
	</ul>
@stop