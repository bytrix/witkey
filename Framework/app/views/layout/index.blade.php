<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta property="qc:admins" content="165725240763150537143516375" />
  <title>Campus Witkey</title>

  {{-- style --}}
  {{-- <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"> --}}
  {{HTML::style(URL::asset('assets/style/bootstrap.min.css'))}}
  {{HTML::style('assets/style/main.css')}}
  {{HTML::style('assets/style/font-awesome.min.css')}}
  {{HTML::style('assets/style/sticky-footer.css')}}
  {{HTML::style(URL::asset('assets/style/select2.css'))}}
  {{-- <link href="http://fk.github.io/select2-bootstrap-css/css/select2-bootstrap.css" rel="stylesheet" /> --}}
  {{HTML::style(URL::asset('assets/style/select2-bootstrap.css'))}}
  {{HTML::style(URL::asset('assets/style/bootstrap-datetimepicker.min.css'))}}
  {{-- <link rel="stylesheet" href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css"> --}}
  {{HTML::style(URL::asset('assets/style/datepicker3.css'))}}

  <style>



  .jumbotron{
    text-align: center;
    /*background-color: #fafafa;*/
    background-color: rgba(0, 0, 0, 0.0);
  }
  .school-select-list{
    margin-top: 40px;
    width: 300px;
  }
  .school-select-list a{
    font-size: 18px;
  }
  .enter:hover{
    text-indent: 6px;
  }
  .navbar-default,
  footer.footer{
    background-color: rgba(248, 248, 248, 0.7);
  }

  </style>


  {{-- script --}}
  {{HTML::script('assets/script/jquery-1.11.3.min.js')}}
  {{HTML::script('assets/script/bootstrap.min.js')}}
  {{HTML::script('assets/script/bootstrap.file-input.js')}}
  {{-- // <script src="http://select2.github.io/select2/select2-3.5.2/select2.js"></script> --}}
  {{HTML::script(URL::asset('assets/script/select2.js'))}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datetimepicker.js'))}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datetimepicker.zh-CN.js'))}}
  {{-- // <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> --}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datepicker.js'))}}
  {{-- // <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script> --}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datepicker.zh-CN.js'))}}
  {{HTML::script(URL::asset('assets/script/particles.js'))}}
  {{HTML::script(URL::asset('assets/script/main.js'))}}
@section('script')
@show

@section('style')
@show

</head>
<body>





    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">
            witkey
            <small class="beta">
              <span class="label label-primary">beta</span>
            </small>
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

          @yield('menu')
          
          <ul class="nav navbar-nav navbar-right">
            @if (Auth::check())
              {{-- <div class="dropdown"> --}}
                <li class="dropdown avatar">
                  
                  <a href="javascript:;" data-toggle="dropdown" style="padding: 12px;">
                    @if (count($unreadMessages))
                      <span class="unread-circle"></span>
                    @endif
                    {{HTML::image(URL::asset('avatar/' . Auth::user()->avatar), '', ['class'=>'avatar-xs cw-xs-img-rounded', 'style'=>'margin-bottom: 0px;'])}}
                    <span class="header-username">{{Auth::user()->username}}</span>
                    <span class="caret"></span>
{{--                     <i class="fa fa-user"></i>
                    {{Auth::user()->username}} --}}
                  </a>

                  <ul class="dropdown-menu">
                    <li><a class="disabled-dropdown-item">{{Auth::user()->email}}</a></li>
                    <li class="divider"></li>
                    <li><a href="/dashboard">{{Lang::get('dashboard.overview')}}</a></li>
                    @if (count($unreadMessages))
                      <li>
                        <a href="/message">
                          <span class="badge badge-danger pull-right">{{count($unreadMessages)}}</span>
                          {{Lang::get('message.message')}}
                        </a>
                      </li>
                    @else
                      <li><a href="/message">{{Lang::get('message.message')}}</a></li>
                    @endif
                    <li><a href="/logout">{{Lang::get('message.logout')}}</a></li>
                  </ul>
                </li>
{{-- 
                <li class="dropdown">

                  <a href="javascript:;" data-toggle="dropdown">
                    <i class="fa fa-gear"></i>
                    Settings
                  </a>

                  <ul class="dropdown-menu">
                    <li><a href="/dashboard">Dashboard</a></li>
                    <li><a href="/dashboard/myProfile">Profile</a></li>
                    <li><a href="/dashboard/taskOrder">Task Order</a></li>
                    <li><a href="/dashboard/favoriteTask">Favorite Task</a></li>
                    <li><a href="/dashboard/myFriends">My Friends</a></li>
                    <li><a href="/dashboard/authentication">Realname Authentication</a></li>
                    <li><a href="/dashboard/security">Security</a></li>
                  </ul>

                </li>
                 --}}
              {{-- </div> --}}
              {{-- <li><a href="/dashboard"><i class="fa fa-user"></i> <strong>{{Auth::user()->username}}</strong></a></li> --}}
              {{-- <li><a href="/logout"><i class="fa fa-sign-out"></i> Logout</a></li> --}}
            @else
              <li><a href="/login">{{Lang::get('message.login')}}</a></li>
              <li><a href="/register">{{Lang::get('message.register')}}</a></li>
            @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<div class="container">
  




    <div class="jumbotron">
      {{-- <h1>Campus Witkey</h1> --}}
      <h1>{{Lang::get('message.campus-witkey')}}</h1>
      {{-- <p>Share your witness with school mates</p> --}}
      <p style="color: #666;">
        <span>智慧</span>
        &bull;
        <span>分享</span>
        &bull;
        <span>创造</span>
      </p>

      <div class="list-group school-select-list center-block">

        @foreach ($academies as $academy)
          <a href="/school/{{$academy->id}}" class="list-group-item enter">
              {{$academy->name}}校区
            <i class="fa fa-angle-right"></i>
          </a>
        @endforeach


        <a class="list-group-item disabled" data-toggle="tooltip" data-placement="bottom" title="暂无校区">其他校区</a>
      </div>

    </div>



</div>

  <div id="particles-js"></div>
  <script>
  /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
  particlesJS.load('particles-js', '/assets/particles.json', function() {
    console.log('callback - particles.js config loaded');
  });
  </script>

  </div>
</body>
</html>