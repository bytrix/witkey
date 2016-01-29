<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Campus Witkey</title>

  {{-- style --}}
  {{-- <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"> --}}
  {{HTML::style(URL::asset('assets/style/bootstrap.min.css'))}}
  {{HTML::style('assets/style/main.css')}}
  {{HTML::style('assets/style/font-awesome.min.css')}}
  {{HTML::style(URL::asset('assets/style/awesome-bootstrap-checkbox.css'))}}
  {{HTML::style('assets/style/sticky-footer.css')}}
  {{HTML::style(URL::asset('assets/style/select2.min.css'))}}
  {{-- <link rel="stylesheet" href="https://select2.github.io/dist/css/select2.min.css"> --}}
  {{-- <link href="http://fk.github.io/select2-bootstrap-css/css/select2-bootstrap.css" rel="stylesheet" /> --}}
  {{-- <link rel="stylesheet" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css"> --}}
  {{HTML::style(URL::asset('assets/style/select2-bootstrap.css'))}}
  {{HTML::style(URL::asset('assets/style/bootstrap-datetimepicker.min.css'))}}
  {{-- <link rel="stylesheet" href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css"> --}}
  {{HTML::style(URL::asset('assets/style/datepicker3.css'))}}

  @yield('procedure-style')



  {{-- script --}}
  {{HTML::script('assets/script/jquery-1.11.3.min.js')}}
  {{HTML::script('assets/script/bootstrap.min.js')}}
  {{HTML::script('assets/script/bootstrap.file-input.js')}}
  {{-- // <script src="http://select2.github.io/select2/select2-3.5.2/select2.js"></script> --}}
  {{HTML::script(URL::asset('assets/script/select2.full.js'))}}
  {{-- // <script src="http://select2.github.io/dist/js/select2.full.js"></script> --}}
  {{-- // <script src="https://select2.github.io/dist/js/select2.min.js"></script> --}}
  {{-- {{HTML::script(URL::asset('assets/script/select2.js'))}} --}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datetimepicker.js'))}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datetimepicker.zh-CN.js'))}}
  {{-- // <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> --}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datepicker.js'))}}
  {{-- // <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script> --}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datepicker.zh-CN.js'))}}
  {{HTML::script(URL::asset('assets/script/main.js'))}}


@section('script')
@show

@section('style')
  <style>
    .header-username{
      /*height: 22px;*/
      /*line-height: 22px;*/
      display: inline-block;
    }
  </style>
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
            <small><span class="label label-primary beta"><i class="arrow"></i>beta</span></small>
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

  @yield('procedure')

	@yield('content')



  <footer class="footer">
    <div class="container">
      <p class="text-muted">
        {{-- <span class="col-sm-4"></span> --}}
        <span class="col-sm-12" style="text-align: center">
          &copy; Campus Witkey.
          Made with <i class="fa fa-heart-o"></i>
        </span>
      </p>
    </div>
  </footer>
  </div>
</body>
</html>