@extends('task.master')

@section('content')
	<div class="container">
		<h1 class="page-header">Bounty Hosting</h1>
		<p>
			<strong>Quoter Name: </strong>
			<span>{{$quote->user->username}}</span>
		</p>
		<p>
			{{HTML::image(URL::asset('avatar/'.$quote->user->avatar))}}
		</p>
		<p>
			<strong>Quote Price: </strong>
			<span>&yen;{{$quote->price}}</span>
		</p>
		<p>
			<strong>Summary: </strong>
			<span>{{$quote->summary}}</span>
		</p>
		<p>
			<a href="/task/{{$task_id}}/hosting/quote/{{$quote->id}}/win_bid" class="btn btn-danger btn-lg">Ok</a>
		</p>
	</div>
@stop