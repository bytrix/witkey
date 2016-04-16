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
	</style>
@stop

@section('script')
	{{HTML::script(URL::asset('assets/script/bootstrap-tagsinput.js'))}}
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
    <li class="active"><a href="/dashboard/myProfile">{{Lang::get('dashboard.my-profile')}}<span class="sr-only">(current)</span></a></li>
    <li><a href="/dashboard/changeAvatar">{{Lang::get('dashboard.change-avatar')}}</a></li>
    <li><a href="/dashboard/taskOrder">{{Lang::get('dashboard.task-order')}}</a></li>
    <li><a href="/dashboard/favoriteTask">{{Lang::get('dashboard.favorite-task')}}</a></li>
  	<li><a href="/dashboard/myFriends">{{Lang::get('dashboard.my-friend')}}</a></li>
  </ul>
  <ul class="nav nav-sidebar nav-list">
  	{{-- <li><a href="/dashboard/postcard">Postcard</a></li> --}}
    <li><a href="/dashboard/authentication">{{Lang::get('dashboard.truename-authentication')}}</a></li>
    <li><a href="/dashboard/security">{{Lang::get('dashboard.security')}}</a></li>
  </ul>
</div>
@stop

@section('user-panel')

@section('header')
@parent
	{{Lang::get('dashboard.my-profile')}}
@stop

@if (Session::has('message'))
	<div class="alert alert-success">{{Session::get('message')}}</div>
@endif

{{Form::open(['class'=>'form-horizontal', 'id'=>'form'])}}
{{Form::token()}}

	{{-- Avatar --}}
{{-- 	<div class="form-group">
		{{Form::label('avatar', '', ['class'=>'control-label col-md-2'])}}
		<div class="col-md-4">
			<div class="img-container">
				<img id="image" src="/avatar/{{Auth::user()->avatar}}">
			</div>
			<input type="file" id="inputImage" class="btn btn-primary pull-right">
		</div>
		<div class="col-md-4">
			<div class="img-preview preview-lg" style="border: 1px solid #ccc; margin: 10px; width: 200px; height: 200px;"></div>
			<div class="img-preview preview-md" style="border: 1px solid #ccc; margin: 10px; width: 40px; height: 40px;"></div>
			<div class="img-preview preview-sm" style="border: 1px solid #ccc; margin: 10px; width: 22px; height: 22px;"></div>
		</div>
	</div> --}}


	{{-- Username --}}
	<div class="form-group">
		{{Form::label('username', Lang::get('user.username'), ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">{{Form::text('username', Auth::user()->username, ['class'=>'form-control'])}}</div>
	</div>

	{{-- Gender --}}
	<div class="form-group">
		{{Form::label('gender', Lang::get('user.gender'), ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
{{-- 
			<label class="radio-inline">
				{{Form::radio('gender', 'M', Auth::user()->gender == 'M' ? true : false)}}Male
			</label>
			<label class="radio-inline">
				{{Form::radio('gender', 'F', Auth::user()->gender == 'F' ? true : false)}}Female
			</label>
--}}
			<div class="radio radio-primary radio-inline">
				{{Form::radio('gender', 'M', Auth::user()->gender == 'M' ? true : false, ['id'=>'male'])}}
				<label for="male">{{Lang::get('user.male')}}</label>
			</div>
			<div class="radio radio-danger radio-inline">
				{{Form::radio('gender', 'F', Auth::user()->gender == 'F' ? true : false, ['id'=>'female'])}}
				<label for="female">{{Lang::get('user.female')}}</label>
			</div>
		</div>
	</div>

	{{-- Tel --}}
	<div class="form-group">
		{{Form::label('tel', Lang::get('user.tel'), ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
				{{Form::text('tel', Auth::user()->tel, ['class'=>'form-control', 'disabled'=>'disabled'])}}
			</div>
		</div>
	</div>

	{{-- Email --}}
	<div class="form-group">
		{{Form::label('email', Lang::get('user.email'), ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
				{{ Form::email('email', Auth::user()->email, ['class'=>'form-control']) }}
			</div>
		</div>
		<div class="col-sm-4">
			<p class="text-success control-text">
				填写邮箱可用于找回密码和收/付款
			</p>
		</div>
	</div>

	{{-- QQ --}}
	<div class="form-group">
		{{Form::label('qq', 'QQ', ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-qq fa-fw"></i></span>
				{{Form::text('qq', Auth::user()->qq, ['class'=>'form-control'])}}
			</div>
		</div>
	</div>

	{{-- Dorm --}}
	<div class="form-group">
		{{Form::label('dorm', Lang::get('user.dorm'), ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			{{Form::text(
				'dorm',
				Auth::user()->dorm=='no' ? Lang::get('user.non-resident') : Auth::user()->dorm,
					[
						'class'=>'form-control',
						'id'=>'dorm',
						Auth::user()->dorm=='no' ? 'disabled' : 'enabled'
					]
			)}}
			{{Form::hidden('dorm_state', '', ['id'=>'dorm_state'])}}
		</div>
		<div class="col-sm-4">
			<div class="checkbox checkbox-primary">
				{{Form::checkbox('resident', 1, Auth::user()->dorm=='no', ['id'=>'residentCheckbox'])}}
				<label for="residentCheckbox">{{Lang::get('user.non-resident')}}</label>
			</div>
			<script>
			$(function() {
				// $('#dorm').attr('enabled', 'enabled');
				$('#residentCheckbox').click(function() {
					if ($('#dorm').attr('enabled') == 'enabled') {
						// Non-resident
						$('#dorm').removeAttr('enabled', 'enabled');
						$('#dorm').attr('disabled', 'disabled');
						$('#dorm').val("{{Lang::get('user.non-resident')}}");
						$('#dorm_state').val('no');
					} else {
						// Resident
						$('#dorm').removeAttr('disabled', 'disabled');
						$('#dorm').attr('enabled', 'enabled');
						$('#dorm').val('');
						$('#dorm_state').val('yes');
					};
				});
			});
			</script>
		</div>
	</div>

	{{-- Biography --}}
	<div class="form-group">
		{{Form::label('biography', Lang::get('user.biography'), ['class'=>'control-label col-md-2'])}}
		<div class="col-md-4">
			{{Form::text('biography', '', ['class'=>'form-control', 'placeholder'=>'如：LOL玩家/漫画迷/业余歌手'])}}
		</div>
	</div>

	{{-- Skill Tag --}}
	<div class="form-group">
		{{Form::label('skill_tag', Lang::get('user.skill'), ['class'=>'control-label col-sm-2'])}}
		<div class="col-sm-4">
			{{Form::text('skill_tag', Auth::user()->skill_tag, ['data-role'=>'tagsinput', 'id'=>'skill-tag'])}}
		</div>
		<div class="col-md-4">
			<p class="text-success control-text">
				英文逗号分隔，如：设计,摄影,写诗
			</p>
		</div>
	</div>

	<div class="form-group">
		<span class="col-sm-2"></span>
		<div class="col-sm-4">{{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary'])}}</div>
	</div>


{{Form::close()}}
@stop