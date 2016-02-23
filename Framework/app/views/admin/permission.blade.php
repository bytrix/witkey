@extends('admin.master')

@section('style')
@parent
<style>
	body{
		/*font-size: 9px;*/
	}
	table img{
		max-height: 24px;
		max-width: 100px;
	}
</style>
@stop


@section('content')
<div ng-app>

	<ol class="breadcrumb">
		<li><a href="/myAdmin/permission">MyAdmin</a></li>
		<li class="active">Permission</li>
	</ol>
		<div class="col-md-4">
			<strong>Number of users:</strong>
			<span>
				{{count(User::all())}}
			</span>
		</div>
		<div class="col-md-4">
			{{-- <h1 align="center">Authentication Board</h1> --}}
			<div class="form-group">
				<input ng-model="value" type="search" name="search" value="" placeholder="Search..." class="form-control">
			</div>
		</div>
		<div class="col-md-4"></div>

		<table class="table table-bordered table-hover table-condensed" ng-controller="UserController">
			<thead>
				<tr>
					<th>Status</th>
					<th>ID</th>
					<th>Truename</th>
					<th>Username</th>
					<th>Email</th>
					<th>Permission</th>
				</tr>
			</thead>
			<tbody>

				@foreach ($users as $user)
					<tr>
						<td>
							@if ($user->authenticated == 0)
								<span class="label label-default">{{Lang::get('authentication.non-authenticated')}}</span>
							@elseif ($user->authenticated ==1)
								<span class="label label-warning">{{Lang::get('authentication.to-be-authenticated')}}</span>
							@elseif ($user->authenticated ==2)
								<span class="label label-success">{{Lang::get('authentication.authenticated')}}</span>
							@elseif ($user->authenticated ==3)
								<span class="label label-danger">{{Lang::get('authentication.authentication-failure')}}</span>
							@endif
						</td>
						<td>{{$user->id}}</td>
						<td>{{$user->truename}}</td>
						<td>{{$user->username}}</td>
						<td>{{$user->email}}</td>
						<td>
							@foreach ($user->getPermission() as $key=>$value)
								@if ($value[2])
									<a href="/myAdmin/chmod/{{$user->id}}/{{$user->permission & $value[1]}}" class="label label-primary">{{$key}}</a>
								@else
									<a href="/myAdmin/chmod/{{$user->id}}/{{$user->permission | $value[0]}}" class="label label-default">{{$key}}</a>
								@endif
							@endforeach
						</td>
					</tr>
				@endforeach

			</tbody>
		</table>

	{{HTML::script(URL::asset('assets/script/admin/auth.js'))}}

</div>
@stop