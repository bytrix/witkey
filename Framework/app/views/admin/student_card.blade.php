@extends('admin.master')

@section('style')
@parent
<style>
	img{
		max-width: 600px;
	}
</style>
@stop

@section('content')
<ol class="breadcrumb">
	<li><a href="/">Admin</a></li>
	<li><a href="/admin/auth">Authentication Board</a></li>
	<li class="active">Student Card</li>
</ol>
<div class="container">
	{{HTML::image(URL::asset('student_card/'.$hash))}}
</div>
@stop