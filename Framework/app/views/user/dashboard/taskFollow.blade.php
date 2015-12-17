@extends('user.dashboard.dashboard')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/profile">Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/taskOrder">Task Order</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li class="active"><a href="/dashboard/taskFollow">Task Follow</a></li>
    <li><a href="/dashboard/authentication">Real-name Authentication</a></li>
  </ul>
</div>
@stop

@section('user-panel')
	<h1 class="page-header">Task Follow</h1>




@stop