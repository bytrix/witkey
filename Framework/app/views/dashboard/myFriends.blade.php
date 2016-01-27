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
    <li><a href="/dashboard">{{Lang::get('dashboard.overview')}}</a></li>
    <li><a href="/dashboard/myProfile">{{Lang::get('dashboard.my-profile')}}</a></li>
    <li><a href="/dashboard/changeAvatar">{{Lang::get('dashboard.change-avatar')}}</a></li>
    <li><a href="/dashboard/taskOrder">{{Lang::get('dashboard.task-order')}}</a></li>
    <li><a href="/dashboard/favoriteTask">{{Lang::get('dashboard.favorite-task')}}</a></li>
    <li class="active"><a href="/dashboard/myFriends">{{Lang::get('dashboard.my-friend')}}<span class="sr-only">(current)</span></a></li>
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
    {{Lang::get('dashboard.my-friend')}}
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