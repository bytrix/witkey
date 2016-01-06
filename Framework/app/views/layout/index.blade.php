<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campus Witkey</title>

  {{-- style --}}
  <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
  {{-- {{HTML::style(URL::asset('assets/style/bootstrap.min.css'))}} --}}
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
    background-color: #fafafa;
  }
  .school-select{
    width: 300px;
  }
  .enter:hover{
    text-indent: 6px;
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

  <script>
  $(function () {
   $('[data-toggle="tooltip"]').tooltip()
  })
  </script>
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
            <small><span class="label label-primary beta"><i class="arrow"></i>beta</span></small>
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

          @yield('menu')
          
          <ul class="nav navbar-nav navbar-right">
            @if (Auth::check())
              <li><a href="/dashboard"><i class="fa fa-envelope-o"></i> <strong>{{Auth::user()->email}}</strong></a></li>
              <li><a href="/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
            @else
              <li><a href="/login">Login</a></li>
              <li><a href="/register">Register</a></li>
            @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<div class="container">
  




    <div class="jumbotron">
      <h1>Campus Witkey</h1>
      <p>Enjoy campus life!</p>

      <div class="list-group school-select center-block">
        <a href="/task/list" class="list-group-item btn-lg enter">
          福州大学至诚学院校区
          {{-- <span class="glyphicon glyphicon-menu-right" style="color: #777"></span> --}}
          <i class="fa fa-angle-right"></i>
        </a>
        <a class="list-group-item disabled btn-lg" data-toggle="tooltip" data-placement="bottom" title="暂无校区">其他校区</a>
      </div>

    </div>



</div>

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