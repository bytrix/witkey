@extends('dashboard.master')

@section('style')
@parent
	{{HTML::style(URL::asset('assets/style/bootstrap-tagsinput.css'))}}
	{{-- {{HTML::style('https://cdnjs.cloudflare.com/ajax/libs/cropper/2.2.5/cropper.min.css')}} --}}
	<style>
		.bootstrap-tagsinput{
			display: block;
		}
		#image{
			width: 330px;
			height: 330px;
		}
		.img-preview{
			float: left;
			overflow: hidden;
		}
		.img-container{
			margin-bottom: 12px;
		}
		.bg{
			padding: 15px;
		}
	</style>
@stop

@section('script')
	{{HTML::script(URL::asset('assets/script/bootstrap-tagsinput.js'))}}
	{{ HTML::script(URL::asset('assets/script/angular.js')) }}
	{{-- {{HTML::script('https://cdnjs.cloudflare.com/ajax/libs/cropper/2.2.5/cropper.min.js')}} --}}
	<script>
	$(function() {
		$('input[type=file]').bootstrapFileInput();
		// var URL = window.URL || window.webkitURL;
		// var blobURL;
		// var file;
		// var croppedCanvas;
		// var croppedImg;
		// $('#image').cropper({
		// 	aspectRatio: 1 / 1,
		// 	preview: '.img-preview',
		// 	crop: function(e) {
		// 		// Output the result data for cropping image.
		// 		// console.log(e.x);
		// 		// console.log(e.y);
		// 		// console.log(e.width);
		// 		// console.log(e.height);
		// 		// console.log(e.rotate);
		// 		// console.log(e.scaleX);
		// 		// console.log(e.scaleY);
		// 	}
		// });

		// $('#crop').click(function() {
		// 	// alert('22');
		// 	// $('#crop-box').html('ss');
		// 	croppedCanvas = $('#image').cropper('getCroppedCanvas');
		// 	$('#crop-box').html(convertCanvasToImage(croppedCanvas));
		// });

		// console.log($('#image').cropper('getCroppedCanvas'));
		// $('#image').cropper('getCroppedCanvas').toBlob(function(blob) {
		// 	console.log('blob: ');
		// 	console.log(blob);
		// });

		// $('#inputImage').change(function() {
		// 	// console.log('changed');
		// 	file = this.files[0];
		// 	blobURL = URL.createObjectURL(file);
		// 	$('#image').cropper('replace', blobURL);
		// });

		// function convertCanvasToImage(canvas) {
		// 	var image = new Image();
		// 	image.src = canvas.toDataURL("image/png");
		// 	return image;
		// 	// return 'sss';
		// }

		// $('#form').submit(function() {
		// 	// alert('sub');
		// 	var formData = new FormData();
		// 	var xhr = new XMLHttpRequest();

		// 	croppedCanvas = $('#image').cropper('getCroppedCanvas');
		// 	formData.append("croppedCanvas", croppedCanvas.toDataURL("image/png"));
		// 	xhr.open("POST", "/dashboard/myProfile");
		// 	xhr.send(formData);
		// 	// alert('s');
		// 	// croppedCanvas = $('#image').cropper('getCroppedCanvas');
		// 	// croppedImg = convertCanvasToImage(croppedCanvas);
		// 	// $('#crop-box').html();
		// 	// console.log(croppedImg);
		// 	// return false;
		// });
	});
	</script>
@stop

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">{{Lang::get('dashboard.overview')}}</a></li>
    <li><a href="/dashboard/myProfile">{{Lang::get('dashboard.my-profile')}}<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/changeAvatar">{{Lang::get('dashboard.change-avatar')}}</a></li>
    <li><a href="/dashboard/taskOrder">{{Lang::get('dashboard.task-order')}}</a></li>
    <li><a href="/dashboard/favoriteTask">{{Lang::get('dashboard.favorite-task')}}</a></li>
  	<li><a href="/dashboard/myFriends">{{Lang::get('dashboard.my-friend')}}</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/authentication">{{Lang::get('dashboard.truename-authentication')}}</a></li>
    <li class="active"><a href="/dashboard/pay-setting">{{Lang::get('dashboard.pay-setting')}}</a></li>
    <li><a href="/dashboard/security">{{Lang::get('dashboard.security')}}</a></li>
  </ul>
</div>
@stop

@section('user-panel')

@section('header')
@parent
	{{Lang::get('dashboard.pay-setting')}}
@stop

@if (Session::has('message'))
	<div class="alert alert-success">{{Session::get('message')}}</div>
@endif

{{Form::open(['class'=>'form-horizontal', 'name'=>'form'])}}
{{Form::token()}}

	<!-- Alipay Account -->
	<div class="form-group">
		{{ Form::label('alipay_account', Lang::get('user.alipay_account'), ['class'=>'control-label col-md-2']) }}
		<div class="col-sm-4">
				<p class="bg bg-primary" id="alipay_account_show">
					@if (Util::isPhone(Auth::user()->alipay_account))
						{{ Auth::user()->asteriskTel() }}
					@elseif (Util::isEmail(Auth::user()->alipay_account))
						{{ Auth::user()->asteriskEmail() }}
					@endif
				</p>
			<div class="radio radio-primary radio-inline">
				@if (Util::isPhone(Auth::user()->alipay_account))
					<input type="radio" name="alipay_account" id="alipay_phone" value="{{ Auth::user()->tel }}" checked="checked"></input>
				@else
					<input type="radio" name="alipay_account" id="alipay_phone" value="{{ Auth::user()->tel }}"></input>
				@endif
				<label for="alipay_phone">使用手机</label>
			</div>
			<div class="radio radio-primary radio-inline">
				@if (Util::isEmail(Auth::user()->alipay_account))
					<input type="radio" name="alipay_account" id="alipay_email" value="{{ Auth::user()->email }}" checked="checked"></input>
				@else
					<input type="radio" name="alipay_account" id="alipay_email" value="{{ Auth::user()->email }}"></input>
				@endif
				<label for="alipay_email">使用邮箱</label>
			</div>
		</div>
	</div>
	@if (Auth::user()->alipay_account == "")
	<script type="text/javascript">
		$(function() {
			$('#alipay_account_show').hide();
			$('#save').attr('disabled', 'disabled');
			// console.log($("#save").attr('value'));
		})
	</script>
	@endif
	<script type="text/javascript">
		$(function() {
			$('#alipay_phone').click(function() {
				$('#alipay_account_show').show();
				$('#alipay_account_show').text("{{ Auth::user()->asteriskTel() }}");
				$('#alipay_account').val('ss');
				$('#save').removeAttr('disabled');
			});
			$('#alipay_email').click(function() {
				$('#alipay_account_show').show();
				$('#alipay_account_show').text("{{ Auth::user()->asteriskEmail() }}");
				if ("{{ Auth::user()->asteriskEmail() }}" == "EMAIL NOT FOUND!") {
					$('#save').attr('disabled', 'disabled');
				} else {
					$('#save').removeAttr('disabled');
				}
			});
		});
	</script>

	<div class="form-group">
		<span class="col-sm-2"></span>
		<div class="col-sm-4">
			{{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary', 'id'=>'save'])}}
		</div>
	</div>

{{Form::close()}}

@stop