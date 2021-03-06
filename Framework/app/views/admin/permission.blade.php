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

	<div class="container">
	
		<ol class="breadcrumb">
			<li><a href="/myadmin">MyAdmin</a></li>

			<li class="dropdown">
				<a href="javascript:;" data-toggle="dropdown" class="active">{{ Lang::get('admin.permission-management') }}</a>
				<ul class="dropdown-menu">
					<li><a href="/myadmin/auth">
						<i class="fa fa-user"></i>
						{{ Lang::get('admin.auth-management') }}
					</a></li>
					<li><a href="/myadmin/academy">
						<i class="fa fa-university"></i>
						{{ Lang::get('admin.academy-management') }}
					</a></li>
					<li><a href="/myadmin/order">
						<i class="fa fa-cube"></i>
						{{ Lang::get('admin.order-management') }}
					</a></li>
				</ul>
			</li>
			<!-- <li class="active">Permission</li> -->
		</ol>


		<h1>
			<i class="fa fa-lock"></i>
			{{ Lang::get('admin.permission-management') }}
		</h1>

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
						<th>状态</th>
						<th>ID</th>
						<th>实名</th>
						<th>用户名</th>
						<th>邮箱</th>
						<th>权限</th>
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
<!-- 
<pre>
{{ var_dump($key) }}
</pre>
<pre>
{{ var_dump($value) }}
</pre>
 -->
									@if ($value[2])
										<a href="/myadmin/chmod/{{$user->id}}/{{$user->permission & $value[1]}}" class="label label-primary">{{ Lang::get('permission.' . $key) }}</a>
									@else
										<!-- <a href="/myadmin/chmod/{{$user->id}}/{{$user->permission | $value[0]}}" class="label label-default">{{ Lang::get('permission.' . $key) }}</a> -->
										<a class="label label-default">{{ Lang::get('permission.' . $key) }}</a>
									@endif
								@endforeach
							</td>
						</tr>
					@endforeach

				</tbody>
			</table>
	</div>

	{{HTML::script(URL::asset('assets/script/admin/auth.js'))}}

</div>
@stop