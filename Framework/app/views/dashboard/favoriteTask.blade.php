@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/myProfile">My Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/taskOrder">Task Order</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li class="active"><a href="/dashboard/favoriteTask">Favorite Task</a></li>
    <li><a href="/dashboard/authentication">Real-name Authentication</a></li>
  </ul>
</div>
@stop

@section('user-panel')
	<h1 class="page-header">Favorite Task</h1>


  <table class="table">
    <thead>
      <th>ID</th>
      <th>Title</th>
      <th>Amount</th>
      <th>Date</th>
    </thead>
    <tbody>

      @foreach ($favoriteTasks as $favoriteTask)
        <tr>
          <td>{{$favoriteTask->id}}</td>
          <td>
            <div class="cw-task-title">
              <a href="/task/{{$favoriteTask->id}}">{{$favoriteTask->title}}</a>
            </div>
          </td>
          <td>{{$favoriteTask->amount}}</td>
          <td>{{$favoriteTask->expiration}}</td>
        </tr>
      @endforeach

    </tbody>
  </table>
{{-- 
  @foreach ($favoriteTasks as $favoriteTask)
    <li>{{$favoriteTask->title}}</li>
  @endforeach
 --}}

@stop