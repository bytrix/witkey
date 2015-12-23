@extends('admin.master')

@section('content')
<div class="container">
	<h1>Authentication Board</h1>
	{{Form::open(['method'=>'post'])}}
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>Email</th>
					<th>Authenticated</th>
				</tr>
			</thead>
			<tbody>

					@foreach ($users as $user)
						<tr>
							<td>{{$user->id}}</td>
							<td>{{$user->username}}</td>
							<td>{{$user->email}}</td>
							<td>
								{{Form::checkbox('authenticated', 0, $user->authenticated)}}
							</td>
						</tr>
					@endforeach

			</tbody>
		</table>
	{{Form::submit('Save', ['class'=>'btn btn-success'])}}
	{{Form::close()}}
</div>
@stop