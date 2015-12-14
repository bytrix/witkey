@extends('layout.task')

@section('menu')
	<ul class="nav navbar-nav">

	<li><a href="/">Home</a></li>
	<li><a href="/demand/new">Publish Demand</a></li>
	<li><a href="/task/list">Task List</a></li>
	<li class="dropdown">
	  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	    <li><a href="/about">About</a></li>
	    {{-- <li><a href="/contact">Contact</a></li> --}}
	  </ul>
	</li>

	</ul>

@stop

@section('content')
	<div class="container">


		<div class="col-md-8">
			<div class="page-header">
				<h1>User info</h1>
			</div>





		</div>

		<div class="col-md-4">
			<div class="profile">
				<div>
					<img src="{{UserController::get_gravatar($user->email)}}" class="thumbnail">
				</div>
				<h4>{{$user->username}}</h4>


				<span>
					<img src="{{URL::asset('assets/image')}}{{$user->gender == 'M' ? '/iconfont-genderman.png' : '/iconfont-genderwoman.png' }}">
				</span>
				<p>Joined on {{explode(' ', $user->created_at)[0]}}</p>




			</div>
		</div>



	</div>
@stop