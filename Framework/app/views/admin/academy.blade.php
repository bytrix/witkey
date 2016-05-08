@extends('admin.master')

@section('content')


<div class="container">
	<ol class="breadcrumb">
		<li><a href="/myadmin">MyAdmin</a></li>

		<li class="dropdown">
			<a href="javascript:;" data-toggle="dropdown" class="active">{{ Lang::get('admin.academy-management') }}</a>
			<ul class="dropdown-menu">
				<li><a href="/myadmin/permission">
					<i class="fa fa-lock"></i>
					{{ Lang::get('admin.permission-management') }}
				</a></li>
				<li><a href="/myadmin/auth">
					<i class="fa fa-user"></i>
					{{ Lang::get('admin.auth-management') }}
				</a></li>
				<li><a href="/myadmin/order">
					<i class="fa fa-cube"></i>
					{{ Lang::get('admin.order-management') }}
				</a></li>
			</ul>
		</li>
		<!-- <li class="active">Academy</li> -->
	</ol>

	<h1>
		<i class="fa fa-university"></i>
		{{ Lang::get('admin.academy-management') }}
	</h1>

	<table class="table">
		<thead>
			<th>Academy ID</th>
			<th>Academy Name</th>
			<th>Created At</th>
		</thead>
		<tbody>

			@foreach ($academies as $academy)
				<tr>
					<td>{{$academy->id}}</td>
					<td>
						<a href="/myadmin/academy/{{$academy->id}}">{{$academy->name}}</a>
					</td>
					<td>{{$academy->created_at}}</td>
				</tr>
			@endforeach

		</tbody>
	</table>

	{{Form::open(['class'=>'form-inline'])}}
		<div class="form-group">
			{{Form::text('name', '', ['class'=>'form-control', 'placeholder'=>'Academy Name'])}}
		</div>
		{{-- {{Form::submit('Add', ['class'=>'btn btn-primary'])}} --}}
		<button class="btn btn-primary">
			<i class="fa fa-plus"></i>
			Add Academy
		</button>
	{{Form::close()}}

</div>
@stop