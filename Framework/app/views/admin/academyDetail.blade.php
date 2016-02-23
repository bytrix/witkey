@extends('admin.master')

@section('content')
	<div class="container">
		{{$academy->name}}


		<table class="table">
			<thead>
				<th>Major ID</th>
				<th>Major Name</th>
			</thead>
			<tbody>
				@foreach ($majors as $major)
					<tr>
						<td>{{$major->id}}</td>
						<td>{{$major->name}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		{{Form::open(['class'=>'form-inline'])}}
			<div class="form-group">
				{{Form::text('major_name', '', ['class'=>'form-control'])}}
				<button type="submit" class="btn btn-primary">
					<i class="fa fa-plus"></i>
					Add Major
				</button>
			</div>
		{{Form::close()}}
	</div>
@stop