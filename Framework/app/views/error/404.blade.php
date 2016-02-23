@extends('layout.master_pure')

@section('style')
@parent
<style>
	.error-404{
		font-size: 140px;
		margin-top: 40px;
		color: #aaa;
		font-family: "3D";
	}
	.container{
		color: #777;
		text-align: center;
	}
</style>
@stop

@section('content')
	<div class="container" >
		<h1 class="error-404">404</h1>
		<p>你请求的页面跑到火星去啦！</p>
		<a href="/" class="btn btn-default">返回地球</a>
	</div>
@stop