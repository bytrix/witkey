@extends('user.dashboard.dashboard')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <li><a href="/dashboard/profile">Profile<span class="sr-only">(current)</span></a></li>
    <li class="active"><a href="/dashboard/mytask">MyTask</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
</div>
@stop

@section('user-panel')
<h1 class="page-header">My Task</h1>
@stop