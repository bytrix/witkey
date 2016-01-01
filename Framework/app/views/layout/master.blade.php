<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Campus Witkey</title>

  {{-- style --}}
  <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
  {{HTML::style('assets/style/font-awesome.min.css')}}
  {{HTML::style('assets/style/main.css')}}
  {{HTML::style('assets/style/sticky-footer.css')}}
  {{HTML::style(URL::asset('assets/style/select2.css'))}}
  {{-- <link href="http://fk.github.io/select2-bootstrap-css/css/select2-bootstrap.css" rel="stylesheet" /> --}}
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
  {{HTML::script(URL::asset('assets/script/select2.js'))}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datetimepicker.js'))}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datetimepicker.zh-CN.js'))}}
  {{-- // <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> --}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datepicker.js'))}}
  {{-- // <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script> --}}
  {{HTML::script(URL::asset('assets/script/bootstrap-datepicker.zh-CN.js'))}}

  <script>
  $(function () {
   $('[data-toggle="tooltip"]').tooltip()
  })
  </script>
@section('script')
@show

  <style>
  body {
    /*min-height: 2000px;*/
    padding-top: 70px;
  }
  .panel-group{
    margin-bottom: 40px;
  }

  .avatar-sm{
    width: 40px;
    margin-right: 12px;
    margin-bottom: 4px;
  }
  .avatar-md{
    width: 130px;
    margin-right: 20px;
  }
  .avatar-lg{
    margin-right: 20px;
  }
  .avatar-bar{
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

  .detail-title{
    width: 570px;
    word-break: break-all;
    display: inline-block;
  }
  .amount{
    font-size: 24px;
    padding-left: 6px;
  }
  .metadata,
  .metadata a{
    color: #888;
    text-decoration: none;
  }
  .metadata a:hover{
    color: #666;
  }
  .metadata .property{
    margin-left: 10px;
  }
  .detail img{
    max-width: 800px;
  }

  </style>

  @section('style')
  @show

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
          <a class="navbar-brand" href="/">
            witkey
            <small><span class="label label-primary">beta</span></small>
          </a>
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