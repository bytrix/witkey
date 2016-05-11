@extends('admin.master')

@section('style')
@parent
	<style type="text/css">
	.major{
		margin: 10px 10px;
		width: 250px;
	}
	.dropdown-menu{
		background-color: rgba(255,255,255,0.9);
	}
	.dropdown-menu>li>a:hover{
		color: #fff;
		background-color: #999;
	}
	</style>
@stop

@section('script')
@parent
	<script type="text/javascript">
	$(function() {
		$('[menu-action="modify"]').click(function() {
			var major_id = $(this).attr('majorid');
			var major_name = prompt('Modify major name');
			if (major_name != null || major_name != "null") {
				$.ajax({
					method: 'get',
					url: '/api/academy/major/modify/' + major_id + '/' + major_name,
					success: function() {
						// window.location.href="ss";
						window.location.reload();
					}
				});
			}
		});
		$('[menu-action="delete"]').click(function() {
			var major_id = $(this).attr('majorid');
			// alert(major_id);
			$.ajax({
				method: 'get',
				url: '/api/academy/major/delete/' + major_id,
				success: function() {
					window.location.reload();
				}
			});
		});
	});
	</script>
@stop

@section('content')
	<div class="container">
		{{$academy->name}}

<!-- 
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
 -->

	<div style="margin-top: 20px; margin-bottom: 40px;">
		@foreach ($majors as $major)
			<div class="btn-group major">
<!-- 
				<span class="dropdown btn btn-default">
					<a href="/" data-toggle="dropdown">ss</a>
					<ul class="dropdown-menu">
						<li><a href="/">ddd</a></li>
						<li><a href="/">ddd</a></li>
						<li><a href="/">ddd</a></li>
					</ul>
				</span>
 -->

				<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					{{ $major->id }}
					:
					{{ $major->name }}
					<span class="caret"></span>
				</a>
<!-- 
				<a class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					{{ $major->id }}
					<span class="caret"></span>
				</a>
				 -->
				<ul class="dropdown-menu">
					<li><a href="javascript:;" menu-action="modify" majorid="{{ $major->id }}">Modify</a></li>
					<li><a href="javascript:;" menu-action="delete" majorid="{{ $major->id }}">Delete</a></li>
				</ul>
			</div>
		@endforeach
	</div>

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