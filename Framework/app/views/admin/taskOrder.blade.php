@extends('admin.master')

@section('script')
@stop

@section('style')
@parent
	{{ HTML::style(URL::asset('/assets/style/awesome-bootstrap-checkbox.css')) }}
@stop

@section('content')

	<div class="container">

	<ol class="breadcrumb">
		<li><a href="/myadmin">MyAdmin</a></li>
		<li class="active">Order Management</li>
	</ol>

		<h1>订单管理</h1>

		<p>
			<div class="checkbox checkbox-primary">
				<input type="checkbox" id="unpaid"></input>
				<label for="unpaid">Show Unpaid Only ({{ $unpaid_orders_num }})</label>
			</div>
		</p>

		<table class="table table-hover table-bordered">
			<thead>
				<th>Trade No</th>
				<th>Title</th>
				<th>Customer</th>
				<th>Pay</th>
				<th>Date</th>
			</thead>
			<tbody>
				@foreach ($orders as $order)
					<tr>
						<td>{{ $order->trade_no }}</td>
						<td>
							<a href="/task/{{ $order->id }}" target="_blank">{{ $order->title }}</a>
						</td>
						<td>
							<a href="/user/{{ $order->user->id }}" target="_blank">{{ $order->user->username }}</a>
						</td>
						<td>
							@if ($order->state == 0)
								<span class="label label-danger">Closed</span>
							@elseif ($order->state == 1 || $order->state == 2 || $order->state == 3)
								<span class="label label-primary">Bidding</span>
							@elseif ($order->state == 4)
								<span class="label label-success">Finished</span>
							@elseif ($order->state == 5)
								<span class="label label-default">Expired</span>
							@elseif ($order->state == 6)
								<span class="label label-warning">Successfull Trade</span>
							@endif
						</td>
						<td>{{ $order->created_at }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>

@stop