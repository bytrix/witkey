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
	.module-icon{
		margin-top: 20px;
		font-size: 40px;
		color: #333;
	}
	.caption h3{
		margin-top: 10px;
	}
</style>
@stop


@section('content')
<div ng-app>

<div class="container">
	<ol class="breadcrumb">
		<li><a href="/myadmin">MyAdmin</a></li>
		<li class="active"><a href="/myadmin">Home</a></li>
	</ol>
</div>


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
					<!-- <img src="#"> -->
					<div class="caption">
						<i class="module-icon fa fa-user"></i>
						<h3>用户认证管理</h3>
					</div>
				</a>
			</div>
			
			<div class="col-md-3 module">
				<a class="thumbnail" href="/myadmin/permission">
					<!-- <img src="#"> -->
					<div class="caption">
						<i class="module-icon fa fa-lock"></i>
						<h3>用户权限管理</h3>
					</div>
				</a>
			</div>

			<div class="col-md-3 module">
				<a class="thumbnail" href="/myadmin/academy">
					<!-- <img src="#"> -->
					<div class="caption">
						<i class="module-icon fa fa-university"></i>
						<h3>学院管理</h3>
					</div>
				</a>
			</div>

			<div class="col-md-3 module">
				<a class="thumbnail" href="/myadmin/order">
					<!-- <img src="#"> -->
					<div class="caption">
						<i class="module-icon fa fa-cube"></i>
						<h3>订单管理</h3>
					</div>
				</a>
			</div>


		</div>

	</div>



</div>
@stop