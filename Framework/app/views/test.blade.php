<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	{{HTML::style(URL::asset('assets/style/bootstrap.min.css'))}}
	<link rel="stylesheet" href="">
</head>
<body>
	<div class="container">
		
	{{Form::open(['url'=>'/admin/User/1/save', 'class'=>'form-horizontal'])}}
		<div class="form-group">
			{{Form::label('username', '', ['class'=>'control-label col-md-2'])}}
			<div class="col-md-4"> {{Form::text('username', 'tom', ['class'=>'form-control'])}} </div>
		</div>
		<div class="form-group">
			{{Form::label('truename', '', ['class'=>'control-label col-md-2'])}}
			<div class="col-md-4"> {{Form::text('truename', 'tm', ['class'=>'form-control'])}} </div>
		</div>
		<div class="form-group">
			{{Form::label('email', '', ['class'=>'control-label col-md-2'])}}
			<div class="col-md-4"> {{Form::email('email', 'tom@github.com', ['class'=>'form-control'])}} </div>
		</div>
		<div class="form-group">
			{{Form::label('school_id', '', ['class'=>'control-label col-md-2'])}}
			<div class="col-md-4"> {{Form::text('school_id', '1', ['class'=>'form-control'])}} </div>
		</div>
		<div class="form-group">
			{{Form::label('id', '', ['class'=>'control-label col-md-2'])}}
			<div class="col-md-4"> {{Form::text('id', '1', ['class'=>'form-control'])}} </div>
		</div>
		<div class="form-group">
			{{Form::label('', '', ['class'=>'control-label col-md-2'])}}
			<div class="col-md-4">{{Form::submit('save', ['class'=>'btn btn-primary'])}}</div>
		</div>
	{{Form::close()}}
	</div>
</body>
</html>