<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Password Reset</h2>

		<div>
			To reset your password, click this link and complete the form: 
			<a href="{{ URL::to('password/reset', array($token)) }}">here</a>
			<br/>
			Or past the link below in your browser:
			<br>
			{{ URL::to('password/reset', array($token)) }}
			<br>
			This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
		</div>
	</body>
</html>
