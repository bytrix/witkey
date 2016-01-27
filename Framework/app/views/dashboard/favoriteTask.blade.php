@extends('dashboard.master')

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
    <li><a href="/dashboard">{{Lang::get('dashboard.overview')}}</a></li>
    <li><a href="/dashboard/myProfile">{{Lang::get('dashboard.my-profile')}}</a></li>
    <li><a href="/dashboard/changeAvatar">{{Lang::get('dashboard.change-avatar')}}</a></li>
    <li><a href="/dashboard/taskOrder">{{Lang::get('dashboard.task-order')}}</a></li>
    <li class="active"><a href="/dashboard/favoriteTask">{{Lang::get('dashboard.favorite-task')}}<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/myFriends">{{Lang::get('dashboard.my-friend')}}</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
    {{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/authentication">{{Lang::get('dashboard.realname-authentication')}}</a></li>
    <li><a href="/dashboard/security">{{Lang::get('dashboard.security')}}</a></li>
  </ul>
</div>
@stop

@section('user-panel')

  @section('header')
  @parent
    {{Lang::get('dashboard.favorite-task')}}
  @stop

@if (count($favoriteTasks))
  <table class="table">
    <thead>
      <th>{{Lang::get('task.task-id')}}</th>
      <th>{{Lang::get('task.title')}}</th>
      <th>{{Lang::get('task.amount')}}</th>
      <th>{{Lang::get('task.date-published')}}</th>
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