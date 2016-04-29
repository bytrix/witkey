<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
{{ Form::open(['files'=>true]) }}

	{{ Form::file('file') }}

	{{ Form::submit('submit') }}

{{ Form::close() }}
</body>
</html>