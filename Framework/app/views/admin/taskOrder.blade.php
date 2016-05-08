@extends('admin.master')

@section('script')
@parent
	<script type="text/javascript">
		var groupPay = new Array();
		var selectedPays = new Array();
		var selectedTasks = new Array();
		var arrayTaskId = new Array();
		$(function() {

			Array.prototype.remove = function(val) {
				var indexOf = this.indexOf(val);
				this.splice(indexOf, 1);
			};

			if (selectedPays.length == 0) {
				$('#submit').attr('disabled', true);
			} else {
				$('#submit').removeAttr('disabled');
			}
			$('#allPay').click(function() {
				// alert('2');
				// var groupPay = $('#payGroup');
				// console.log(groupPay.length);
				if ($(this).attr('checked') == undefined) {
					// console.log($(this).attr('checked'));
					$(this).attr('checked', true);
					// groupPay.forEach(function(element) {
					// 	console.log(element.attr('checked'));
					// 	element.attr('checked', true);
					// });
					// groupPay.each(function() {
					// 	console.log($(this));
					// });
					$.each(groupPay, function(k, v) {
						v.attr('checked', true);
					});
				} else {
					// console.log($(this).attr('checked'));
					// $(this).attr('checked', false);
					$(this).removeAttr('checked');
					$.each(groupPay, function(k, v) {
						// console.log(k);
						// console.log(v);
						v.removeAttr('checked');
					});
					// groupPay.forEach(function(element) {
					// 	console.log(element.attr('checked'));
					// 	// element.attr('checked', false);
					// 	element.removeAttr('checked');
					// });
				}
				// groupPay.forEach(function(element) {
				// 	// console.log(e);
				// 	element.attr('checked', true);
				// })
			});
		});
	</script>
@stop

@section('style')
@parent
	{{ HTML::style(URL::asset('/assets/style/awesome-bootstrap-checkbox.css')) }}
@stop

@section('content')

	<div class="container">

	<ol class="breadcrumb">
		<li><a href="/myadmin">MyAdmin</a></li>

		<li class="dropdown">
			<a href="javascript:;" data-toggle="dropdown" class="active">{{ Lang::get('admin.order-management') }}</a>
			<ul class="dropdown-menu">
				<li><a href="/myadmin/permission">
					<i class="fa fa-lock"></i>
					{{ Lang::get('admin.permission-management') }}
				</a></li>
				<li><a href="/myadmin/auth">
					<i class="fa fa-user"></i>
					{{ Lang::get('admin.auth-management') }}
				</a></li>
				<li><a href="/myadmin/academy">
					<i class="fa fa-university"></i>
					{{ Lang::get('admin.academy-management') }}
				</a></li>
			</ul>
		</li>
		<!-- <li class="active">Order Management</li> -->
	</ol>

		<h1>
			<i class="fa fa-cube"></i>
			{{ Lang::get('admin.order-management') }}
		</h1>

		<div id="taskId">
			<!-- task_id -->
		</div>

		<p>
			<div class="checkbox checkbox-primary">
				<input type="checkbox" id="unpaid"></input>
				<label for="unpaid">Show Unpaid Only (<b>{{ $unpaid_orders_num }}</b>)</label>
			</div>
		</p>

		<table class="table table-hover table-bordered">
			<thead>
				<th>Trade No</th>
				<th>Title</th>
				<th>Customer</th>
				<th>State</th>
				<th>
					<div class="checkbox checkbox-success" style="margin: 0px;">
						<input type="checkbox" id="allPay"></input>
						<label for="allPay"><b>Pay All</b></label>
					</div>
				</th>
				<th>Date</th>
			</thead>
			<tbody>
				@foreach ($orders as $order)
					@if ($order->state == 4)
					<tr style="font-weight: bold; background-color: rgba(0,240,0,0.2);">
					@else
					<tr>
					@endif
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
						<td>
							@if ($order->state == 4)

								<div class="checkbox checkbox-success" style="margin: 0px;">
									<input type="checkbox" id="pay_item_{{ $order->id }}" taskid = "{{ $order->id }}"></input>
									<label for="pay_item_{{ $order->id }}">Pay Now</label>
								</div>
								
								<script type="text/javascript">
									var payItem = $("#pay_item_{{ $order->id }}");
									groupPay.push(payItem);
									payItem.click(function() {
										// alert('s');
										if ($(this).attr('checked') == undefined) {
											// alert('s');
											$(this).attr('checked', 'checked');
											selectedPays.push($(this));
											// alert($(this).attr('taskid'));
											arrayTaskId.push($(this).attr('taskid'));
										} else {
											$(this).removeAttr('checked');
											selectedPays.pop($(this));
											// arrayTaskId.pop($(this).attr('taskid'));
											arrayTaskId.remove($(this).attr('taskId'));
										}
										// console.log(selectedPays.length);
										// selectedPays.push(payItem)
										$('#submit').val('批量付款（选中' + selectedPays.length + '项）');
										if (selectedPays.length == 0) {
											$('#submit').attr('disabled', true);
										} else {
											$('#submit').removeAttr('disabled');
										}
										// console.log(arrayTaskId);
										$('#taskIds').val(arrayTaskId);
									});
								</script>
							@endif
						</td>
						<td>{{ $order->created_at }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<div>
			<!-- <input type="submit" value="批量付款（选中0项）" id="submit" class="btn btn-primary"></input> -->
			{{ Form::open() }}
				{{ Form::text('taskIds', 'value', ['id'=>'taskIds', 'hidden'=>true]) }}
				{{ Form::submit('批量付款（选中0项）', ['id'=>'submit', 'class'=>'btn btn-primary']) }}
			{{ Form::close() }}
		</div>

	</div>

@stop