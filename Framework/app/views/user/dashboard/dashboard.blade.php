@extends('layout.home')

@section('style')
  {{HTML::style('assets/style/dashboard.css')}}
@stop

@section('content')

    <div class="container-fluid">
      <div class="row">

          @yield('control-panel')

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          @yield('user-panel')
        </div>

      </div>
    </div>

@stop