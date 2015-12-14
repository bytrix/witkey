@extends('layout.home')

@section('style')
<style>
  .category-block{
    background-color: #ccc;
    width: 300px;
    height: 160px;
    line-height: 160px;
    text-align: center;
    font-size: 20px;
    margin: 20px;
    margin-left: 20px;
  }
</style>
@stop


@section('content')

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Campus Witkey</h1>
        <p>Enjoy school life.</p>

        <p>
          <a class="btn btn-lg btn-primary" href="/" role="button">Explore &raquo;</a>
        </p>
      </div>



      <div class="col-sm-4">
        <div class="category-block">
          Study guide
        </div>
        <div class="category-block">
          Buy breakfast
        </div>
        <div class="category-block">
          Express delivery
        </div>
      </div>

      <div class="col-sm-4">
        <div class="category-block">
          Computer maintenance
        </div>
        <div class="category-block">
          Hiring
        </div>
        <div class="category-block">
          Boon for student
        </div> 
      </div>

      <div class="col-sm-4">
        <div class="category-block">
          Part-time job
        </div>
        <div class="category-block">
          Gaming
        </div> 
        <div class="category-block">
          Others
        </div>  
      </div>

    </div> <!-- /container -->

@endsection