<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		{{ HTML::style('assets/style/bootstrap.min.css') }}
		<style type="text/css">
		.link{
			padding: 16px 32px;
			background-color: #f0f0f0;
			color: #222;
			margin-bottom: 8px;
		}
		</style>
	</head>
	<body>
		<h2>Hi, 亲爱的 {{ $user->username }}</h2>
		<div>
			<p>
				您的登录账号为：{{ $user->tel }}
			</p>
			<p>
				请点击链接并填写表单，以便重新设置您的密码：
				<a href="{{ URL::to('password/reset', array($token)) }}">点我</a>
			</p>

			<p>
				如果无法打开链接，请将下面这条链接复制到您的浏览器的地址栏再访问。
				<div class="link">
					{{ URL::to('password/reset', array($token)) }}
				</div>
				<span style="color: #999; font-size: 12px;">
					（该链接在{{ Config::get('auth.reminder.expire', 60) }}分钟内有效，{{ Config::get('auth.reminder.expire', 60) }}分钟后需要重新获取）
				</span>
			</p>

			<p>
				感谢您对校园威客的支持，希望您在校园威客获得好的服务体验。
				<br>
				（这是一封系统邮件，请勿回复。）
			</p>

		</div>
	</body>
</html>
