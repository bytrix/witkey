@extends('dashboard.master')

@section('style')
@parent
<style>
  .avatar-90{
    width: 90px;
    height: 90px;
  }
  .friend-group-item{
    border: 2px solid rgba(0, 0, 0, 0.0);
    padding: 10px;
    transition: 0.2s;
  }
  .friend-group-item:hover{
    /*border: 2px solid rgba(0, 0, 0, 0.05);*/
    background-color: rgba(200, 200, 200, 0.1);
  }
</style>
@stop

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
    <li><a href="/dashboard">Overview</a></li>
    <li><a href="/dashboard/myProfile">My Profile</a></li>
    <li><a href="/dashboard/changeAvatar">Change Avatar</a></li>
    <li><a href="/dashboard/taskOrder">Task Order</a></li>
    <li><a href="/dashboard/favoriteTask">Favorite Task</a></li>
    <li class="active"><a href="/dashboard/myFriends">My Friends<span class="sr-only">(current)</span></a></li>
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

    @foreach ($friends as $friend)
      {{-- <li>{{$friend->username}}</li> --}}
      <div class="col-md-6 friend-group-item">
          <div style="float: left" >
          <p>
            <a href="/user/{{$friend->id}}" target="blank">
              {{HTML::image("avatar/$friend->avatar", '', ['class'=>'avatar-90', 'style'=>'float: left; margin-right: 20px; margin-bottom: 12px;'])}}
            </a>
          </p>
          <p>
            <a href="/message/send?friend_id={{$friend->id}}" class="btn btn-danger btn-xs">Send Message</a>
          </p>
        </div>

        <p>
          <a href="/user/{{$friend->id}}" target="blank" data-toggle="tooltip" data-placement="right" title="View TA's profile">
            <h4>{{$friend->username}}</h4>
          </a>
        </p>
        <p>
          {{Academy::get($friend->school)['name']}}
        </p>
        <p>
          {{Major::get($friend->major)['name']}}
        </p>
      </div>
    @endforeach

@stop