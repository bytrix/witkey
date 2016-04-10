@extends('admin.master')

@section('script')
{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

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
		<li><a href="/myAdmin">MyAdmin</a></li>
		<li class="active">Home</li>
	</ol>

	<ul>
		<li><a href="/myAdmin/auth">用户认证管理</a></li>
		<li><a href="/myAdmin/permission">用户权限管理</a></li>
		<li><a href="/myAdmin/academy">学院管理</a></li>
	</ul>


</div>
@stop