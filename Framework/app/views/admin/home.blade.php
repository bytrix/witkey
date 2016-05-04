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
	.module{
		text-align: center;
	}
</style>
@stop


@section('content')
<div ng-app>

	<ol class="breadcrumb">
		<li><a href="/myadmin">MyAdmin</a></li>
		<li class="active">Home</li>
	</ol>
<!-- 
	<ul>
		<li><a href="/myadmin/auth">用户认证管理</a></li>
		<li><a href="/myadmin/permission">用户权限管理</a></li>
		<li><a href="/myadmin/academy">学院管理</a></li>
	</ul>
 -->
	<div class="container">
		

		<div class="row">

			<div class="col-md-3 module">
				<a class="thumbnail" href="/myadmin/auth">
					<img src="#">
					<div class="caption">
						<h3>用户认证管理</h3>
					</div>
				</a>
			</div>
			
			<div class="col-md-3 module">
				<a class="thumbnail" href="/myadmin/permission">
					<img src="#">
					<div class="caption">
						<h3>用户权限管理</h3>
					</div>
				</a>
			</div>

			<div class="col-md-3 module">
				<a class="thumbnail" href="/myadmin/academy">
					<img src="#">
					<div class="caption">
						<h3>学院管理</h3>
					</div>
				</a>
			</div>

			<div class="col-md-3 module">
				<a class="thumbnail" href="/myadmin/order">
					<img src="#">
					<div class="caption">
						<h3>订单管理</h3>
					</div>
				</a>
			</div>


		</div>

	</div>



</div>
@stop