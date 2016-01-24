@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
    <li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/myProfile">My Profile</a></li>
    <li><a href="/dashboard/changeAvatar">Change Avatar</a></li>
    <li><a href="/dashboard/taskOrder">Task Order</a></li>
    <li class="active"><a href="/dashboard/favoriteTask">Favorite Task<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/myFriends">My Friends</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
    {{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/authentication">Real-name Authentication</a></li>
    <li><a href="/dashboard/security">Security</a></li>
  </ul>
</div>
@stop

@section('user-panel')

  @section('header')
  @parent
    Favorite Task
  @stop

@if (count($favoriteTasks))
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
@else
  <p class="alert alert-danger">No favorite tasks</p>
@endif

{{-- 
  @foreach ($favoriteTasks as $favoriteTask)
    <li>{{$favoriteTask->title}}</li>
  @endforeach
 --}}

@stop