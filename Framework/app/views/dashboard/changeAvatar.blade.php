@extends('dashboard.master')

@section('style')
@parent
	{{HTML::style(URL::asset('assets/style/bootstrap-tagsinput.css'))}}
	{{HTML::style('https://cdnjs.cloudflare.com/ajax/libs/cropper/2.2.5/cropper.min.css')}}
	<style>
		.bootstrap-tagsinput{
			display: block;
		}
		#image{
			width: 330px;
			height: 330px;
		}
		.img-preview{
			/*float: left;*/
			overflow: hidden;
		}
		.img-container{
			margin-bottom: 12px;
		}
	</style>
@stop

@section('script')
	{{HTML::script(URL::asset('assets/script/bootstrap-tagsinput.js'))}}
	{{HTML::script('https://cdnjs.cloudflare.com/ajax/libs/cropper/2.2.5/cropper.min.js')}}
	<script>
	$(function() {
		$('input[type=file]').bootstrapFileInput();
		var URL = window.URL || window.webkitURL;
		var blobURL;
		var file;
		var croppedCanvas;
		var croppedImg;
		$('#image').cropper({
			aspectRatio: 1 / 1,
			preview: '.img-preview',
			crop: function(e) {
				// Output the result data for cropping image.
				// console.log(e.x);
				// console.log(e.y);
				// console.log(e.width);
				// console.log(e.height);
				// console.log(e.rotate);
				// console.log(e.scaleX);
				// console.log(e.scaleY);
			}
		});

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

		$('#inputImage').change(function() {
			// console.log('changed');
			file = this.files[0];
			blobURL = URL.createObjectURL(file);
			$('#image').cropper('replace', blobURL);
		});

		// function convertCanvasToImage(canvas) {
		// 	var image = new Image();
		// 	image.src = canvas.toDataURL("image/png");
		// 	return image;
		// 	// return 'sss';
		// }

		$('#form').submit(function() {
			// alert('sub');
			var formData = new FormData();
			var xhr = new XMLHttpRequest();

			croppedCanvas = $('#image').cropper('getCroppedCanvas');
			// alert(croppedCanvas);
			formData.append("croppedCanvas", croppedCanvas.toDataURL("image/png"));
			xhr.open("POST", "/dashboard/changeAvatar/");
			xhr.send(formData);
			// console.log('URL: ' + URL);
			// console.log('croppedCanvas: ' + croppedCanvas);
			// console.log('formData: ' + formData);
			// console.log('xhr: ' + xhr);
			alert('Save successfully!');
			return false;
			// alert('s');
			// croppedCanvas = $('#image').cropper('getCroppedCanvas');
			// croppedImg = convertCanvasToImage(croppedCanvas);
			// $('#crop-box').html();
			// console.log(croppedImg);
			// return false;
		});
	});
	</script>
@stop

@section('control-panel')
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar nav-list">
  	<li><a href="/dashboard">{{Lang::get('dashboard.overview')}}</a></li>
    <li><a href="/dashboard/myProfile">{{Lang::get('dashboard.my-profile')}}</a></li>
    <li class="active"><a href="/dashboard/changeAvatar">{{Lang::get('dashboard.change-avatar')}}<span class="sr-only">(current)</span></a></li>
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
	{{Lang::get('dashboard.change-avatar')}}
@stop

@if (Session::has('message'))
	<div class="alert alert-success">{{Session::get('message')}}</div>
@endif

{{Form::open(['class'=>'form-horizontal', 'id'=>'form'])}}
{{Form::token()}}

	{{-- Avatar --}}
	<div class="form-group">
		<span class="col-md-2"></span>

		<div class="col-md-4">
			<div class="img-container">
				<img id="image" src="/avatar/{{Auth::user()->avatar}}">
			</div>
			<input type="file" id="inputImage" class="btn btn-primary pull-right">
		</div>
		<div class="col-md-4">
			<div class="img-preview preview-lg" style="float: left; border: 1px solid #ccc; margin: 10px; width: 200px; height: 200px;"></div>
			<div>
				<div class="img-preview preview-md" style="border: 1px solid #ccc; margin: 10px; width: 52px; height: 52px;"></div>
				<div class="img-preview preview-sm" style="border: 1px solid #ccc; margin: 10px; width: 28px; height: 28px;"></div>
			</div>
		</div>
	</div>



	<div class="form-group">
		<span class="col-sm-2"></span>
		<div class="col-sm-4">{{Form::submit(Lang::get('message.save'), ['class'=>'btn btn-primary'])}}</div>
	</div>


{{Form::close()}}
@stop