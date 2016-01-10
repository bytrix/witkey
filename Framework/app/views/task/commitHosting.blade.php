@extends('task.master')

@section('content')
	<div class="container">
		<h1 class="page-header">Bounty Hosting</h1>
		<p>
			<strong>Bidder Name: </strong>
			<span>{{$commit->user->username}}</span>
		</p>
		<p>
			{{HTML::image(URL::asset('avatar/'.$commit->user->avatar), '', ['class'=>'avatar-sm'])}}
		</p>


		<p>
			<strong>Summary: </strong>
			<span>{{$commit->summary}}</span>
		</p>
		<p>
			@if ($task->type == 1)
				<a href="/task/{{$task->id}}/hosting/{{$commit->id}}/win_bid" class="btn btn-danger btn-lg">Ok</a>
			@endif
		</p>
	</div>
@stop