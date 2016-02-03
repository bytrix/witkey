@extends('user.master')

@section('script')
{{HTML::script(URL::asset('assets/script/angular.js'))}}
@stop

@section('content')
	<div class="container" ng-app>
		<div class="page-header">
			<h1>{{Lang::get('task.report-this-user')}}</h1>
		</div>


		<div class="col-md-5">
			{{Form::open(['class'=>'form-horizontal'])}}

				<div class="form-group">
					{{Form::label('id', '', ['class'=>'control-label col-md-6'])}}
					<span class="col-md-6 control-text">{{$user->id}}</span>
				</div>
				
				<div class="form-group">
					{{Form::label('user', Lang::get('user.username'), ['class'=>'control-label col-md-6'])}}
					<div class="col-md-6">
						<img src="/avatar/{{$user->avatar}}" class="avatar-md img-rounded">
						<p style="width: 130px; text-align: center">
							<a href="/user/{{$user->id}}">{{$user->username}}</a>
						</p>
					</div>
				</div>

				<div class="form-group">
					{{Form::label('email', '', ['class'=>'control-label col-md-6'])}}
					<span class="col-md-6 control-text">{{$user->email}}</span>
				</div>

			{{Form::close()}}
		</div>

		<div class="col-md-5">
			
			{{Form::open(['class'=>'form-horizontal', 'name'=>'reportForm'])}}
				<div class="form-group">
					{{Form::label('reason', Lang::get('task.reason-for-reporting'), ['class'=>'control-label'])}}
				</div>
				<div class="form-group">
					{{Form::textarea('reason', '', ['class'=>'form-control', 'required', 'ng-model'=>'reason'])}}
				</div>
				<div class="form-group">
					{{Form::submit(Lang::get('message.send'), ['class'=>'btn btn-primary pull-right', 'ng-disabled'=>'reportForm.$invalid'])}}
				</div>
			{{Form::close()}}

		</div>



	</div>
@stop