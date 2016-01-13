@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
    <li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/myProfile">My Profile<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/taskOrder">Task Order</a></li>
    <li><a href="/dashboard/favoriteTask">Favorite Task</a></li>
    <li class="active"><a href="/dashboard/myFriends">My Friends</a></li>
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
    My Friends
  @stop

  {{-- {{var_dump($friends)}} --}}

  <ul>
    @foreach ($friends as $friend)
      <li>{{$friend->username}}</li>
    @endforeach
  </ul>

@stop