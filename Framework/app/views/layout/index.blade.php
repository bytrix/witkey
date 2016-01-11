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
            <small class="beta">
              <span class="label label-primary">beta</span>
            </small>
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
      <p>Share your witness with others</p>

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