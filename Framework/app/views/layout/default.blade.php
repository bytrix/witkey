<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
  {{HTML::style('assets/style/bootstrap.min.css')}}
  @yield('style')

  {{HTML::script('assets/script/jquery-1.11.3.min.js')}}
  {{HTML::script('assets/script/bootstrap.min.js')}}

  <style>
  body {
    min-height: 2000px;
    padding-top: 70px;
  }
  </style>
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
          <ul class="nav navbar-nav">
            <li class="active"><a href="/">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Task Center <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">New Task</a></li>
                <li><a href="#">Get Task</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            @if (Auth::check())
              <li><a href="/dashboard">Dashboard ({{Auth::user()->email}})</a></li>
              <li><a href="/logout">Logout</a></li>
            @else
              <li><a href="/login">Login</a></li>
              <li><a href="/register">Register</a></li>
            @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

	@yield('content')
</body>
</html>