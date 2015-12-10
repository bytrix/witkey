@extends('layout.home')

@section('menu')
	<ul class="nav navbar-nav">
	<li><a href="/">Home</a></li>
	<li class="active"><a href="/about">About</a></li>
	<li><a href="/contact">Contact</a></li>
	<li class="dropdown">
	  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Task Center <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	    <li><a href="/task/new">Publish Task</a></li>
	    <li><a href="/task/list">Task List</a></li>
	  </ul>
	</li>
	</ul>
@stop