@extends('task.master')

@section('content')
	<div class="container">
		<h1 class="page-header">Bounty Hosting</h1>
		<p>
			{{HTML::image(URL::asset('avatar/'.$quote->user->avatar), '', ['class'=>'avatar-sm'])}}
		</p>
		<p>
			<strong>Bidder Name: </strong>
			<span>{{$quote->user->username}}</span>
		</p>
		<p>
			<strong>Bidder Email: </strong>
			<span>{{$quote->user->email}}</span>
		</p>
		<p>
			<strong>Price: </strong>
			<span>&yen;{{$quote->price}}</span>
		</p>
		<p>
			<strong>Summary: </strong>
			<span>{{$quote->summary}}</span>
		</p>
		<p>
			@if ($task->type == 2)
				<a href="/task/{{$task->id}}/hosting/{{$quote->id}}/win_bid" class="btn btn-danger btn-lg">Ok</a>
			@endif
		</p>
	</div>
@stop