@extends('layout.master')

@section('style')
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
@stop

@section('script')
  {{HTML::script(URL::asset('assets/script/particles.js'))}}
@stop

@section('content')
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

@stop