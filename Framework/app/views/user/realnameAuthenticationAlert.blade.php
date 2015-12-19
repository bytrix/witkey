@extends('layout.home')

@section('menu')
	<ul class="nav navbar-nav">

	<li><a href="/">Home</a></li>
	<li><a href="/task/list">Task List</a></li>
	<li><a href="/task/new">Publish Task</a></li>
	<li>
	  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	    <li><a href="/about">About</a></li>
	    {{-- <li><a href="/contact">Contact</a></li> --}}
	  </ul>
	</li>

	</ul>
@stop

@section('content')
<div class="container">
	<div class="alert alert-danger">
		<h4>Permission Deny</h4>
		You are not passed through Realname Authentication,please login to your <a class="alert-link" href="/dashboard/authentication">dashboard</a> and authenticate.
	</div>
</div>
@stop