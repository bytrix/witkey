<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Campus Witkey</title>
	<link rel="stylesheet" href="">
  {{HTML::style('assets/style/bootstrap.min.css')}}
  {{HTML::style('assets/style/font-awesome.min.css')}}
  {{HTML::style('assets/style/main.css')}}
  @yield('procedure-style')

  {{HTML::script('assets/script/jquery-1.11.3.min.js')}}
  {{HTML::script('assets/script/bootstrap.min.js')}}
  {{HTML::script('assets/script/bootstrap.file-input.js')}}

  <style>
  body {
    min-height: 2000px;
    padding-top: 70px;
  }
  .panel-group{
    margin-bottom: 40px;
  }

  .avatar-sm{
    /*float: left;*/
    width: 30px;
    margin-right: 12px;
    margin-bottom: 4px;
  }
  .avatar-md{
    /*float: left;*/
    width: 130px;
    margin-right: 20px;
  }
  .avatar-lg{
    /*float: left;*/
    margin-right: 20px;
  }
  .avatar-bar{
    /*background-color: red;*/
    margin-bottom: 10px;
    padding: 10px;
  }
  .detail{
    padding: 10px;
    padding-left: 20px;
    display: block;
  }
  .fa-mars{
    color: #286090;
    font-weight: bold;
  }
  .fa-venus{
    color: #d9534f;
    font-weight: bold;
  }

  </style>
  @yield('style')
</head>
<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">witkey</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

          @yield('menu')
          
          <ul class="nav navbar-nav navbar-right">
            @if (Auth::check())
              <li><a href="/dashboard"><i class="fa fa-envelope"></i> <strong>{{Auth::user()->email}}</strong></a></li>
              <li><a href="/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
            @else
              <li><a href="/login">Login</a></li>
              <li><a href="/register">Register</a></li>
            @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

  @yield('procedure')

	@yield('content')
</body>
</html>