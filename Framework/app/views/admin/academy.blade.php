@extends('admin.master')

@section('content')
	<div class="container">
		<h1>Academy</h1>

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
							<a href="/myAdmin/academy/{{$academy->id}}">{{$academy->name}}</a>
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