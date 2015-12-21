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
  {{HTML::style('assets/style/sticky-footer.css')}}

  @yield('procedure-style')

  {{HTML::script('assets/script/jquery-1.11.3.min.js')}}
  {{HTML::script('assets/script/bootstrap.min.js')}}
  {{HTML::script('assets/script/bootstrap.file-input.js')}}

  <script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  </script>
  @yield('script')

  <style>
  body {
    /*min-height: 2000px;*/
    padding-top: 70px;
  }
  .panel-group{
    margin-bottom: 40px;
  }

  .avatar-sm{
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
    word-break: break-all;
  }
  .fa-mars{
    color: #286090;
    font-weight: bold;
  }
  .fa-venus{
    color: #d9534f;
    font-weight: bold;
  }

  #edit{
    font-size: 0.8em;
    cursor: pointer;
    color: #666;
    margin-left: 0.6em;
    margin-right: 0.7em;
  }
  #edit:hover{
    color: #333;
  }

  .favorite{
    cursor: pointer;
    font-size: 0.8em;
    margin-top: 0.3em;
    margin-right: 1.7em;
    color: red;
  }
  #tip{
    display: block;
    margin-left: -20px;
    position: absolute;
    color: red;
    font-size: 12px;
    /*background-color: blue;*/
    width: 60px;
    text-align: center;
  }
  .detail-title{
    width: 570px;
    word-break: break-all;
    display: inline-block;
    /*background-color: red;*/
    /*float: left;*/
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

  <footer class="footer">
    <div class="container">
      <p class="text-muted">
        <span class="col-sm-4"></span>
        <span class="col-sm-4" align="center">
          &copy; Campus Witkey.
          Made with <i class="fa fa-heart"></i>
        </span>
      </p>
    </div>
  </footer>
  </div>
</body>
</html>