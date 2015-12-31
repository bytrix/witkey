<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	{{HTML::style(URL::asset('assets/style/bootstrap.min.css'))}}
	{{HTML::script(URL::asset('assets/script/jquery-1.11.3.min.js'))}}
</head>
<body>
	<h1>test</h1>

	<div class="progress">
		<div class="progress-bar progress-bar-success progress-bar-striped active" aria-valuemax="100" id="bar" style="width: 20%;"></div>
	</div>
	<button id="btn">set</button>

	<script>
	var n = 0;
	$('#btn').mousedown(function() {
		n++;
		console.log(n);
		$('#bar').attr('style', "width: " + n + "%;").html(n + '%');
	});
	</script>

</body>
</html>