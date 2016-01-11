@extends('task.publish.master')

@section('style')

<style>
	.end-price-bar{
		font-size: 20px;
		display: block;
		padding: 10px;
		float: right;
	}
	.end-price-bar strong{
		font-size: 25px;
		padding-left: 12px;
	}
	.cw-task-title{
		max-width: 900px;
	}
</style>
@stop

@section('content')
	<div class="container">
		<h1 class="page-header">
			Success

	          <small class="pull-right school-select-wrap">
	            School:
	            <div class="dropdown pull-right">
	              <a href="javascript:;" class="link school-select" data-toggle="dropdown">{{$mySchool->name}}</a>
	              <ul class="dropdown-menu">
					@foreach ($schools as $school)
						<li><a href="/school/{{$school->id}}">
							{{$school->name}}
							@if ($mySchool->id == $school->id)
								<i class="fa fa-check text-success"></i>
							@endif
						</a></li>
					@endforeach
	              </ul>
	            </div>
	          </small>
	          
		</h1>
		<ul class='task-procedure third state'>
			<li class="first third col-md-4">CREATE TASK</li>
			<li class="second third col-md-4">SET REWARD</li>
			<li class="third col-md-4 light">PUBLISH</li>
		</ul>
	</div>
	<div class="container">
{{-- 
<pre>
	{{dd(Session::all())}}
</pre>
 --}}
		<div class="form-custom">

			<p>
				<strong>Task Title: </strong>
				<h2 class="cw-task-title">{{Session::get('title')}}</h2>
			</p>
			{{-- <p><strong>Reward:</strong> &yen;{{Session::get('amount')}}</p> --}}
			<p>
				<strong>Task description: </strong>
				<br>
				<p class="detail">
					{{Session::get('detail')}}
				</p>
			</p>

				<div class="end-price-bar">
					@if (Session::get('type') == 1)
						<span>Reward:</span>
					@elseif (Session::get('type') == 2)
						<span>Budget:</span>
					@endif
					<strong>&yen;{{{Session::get('amount')}}}</strong>
				</div>

			<div style="clear: both">
				{{-- {{HTML::link('task/create/step-2', 'Previous', ['class'=>'btn btn-default'])}} --}}
				{{-- {{HTML::link('task/create/postCreate', 'Publish', ['class'=>'btn btn-primary'])}} --}}
				<a href="/task/create/step-2" class="btn btn-default">
					<i class="fa fa-angle-double-left"></i>
					Previous
				</a>
				<a href="/task/create/postCreate" class="btn btn-success">
					Publish
					<i class="fa fa-check"></i>
				</a>
			</div>

		</div>
	</div>
@stop
