@extends('layouts.header')
@section('title', 'Commission Settings')
@section('content')
<section class="content">
	<header class="content__title">
		<h1>Blog Settings</h1>
	</header>
	@if(session('status'))
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> {{ session('status') }}
	</div>
	@endif
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<a href="{{ url('admin/news') }}"><i class="zmdi zmdi-arrow-left"></i> Back to New</a>
					<br /><br />
					<form method="post" action="{{ url('admin/news_save') }}" enctype="multipart/form-data" autocomplete="off">
						{{ csrf_field() }}
						<!-- <input type="hidden" value="" name="id"> -->
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Title</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="title" class="form-control" value=""><i class="form-group__bar"></i>

											@if ($errors->has('title'))
									<span class="help-block">
										<strong>{{ $errors->first('title') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Description</label>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
								<textarea class="ckeditor" name="description">
								</textarea>
									@if ($errors->has('description'))
										<span class="help-block">
											<strong>{{ $errors->first('description') }}</strong>
										</span>
									@endif
									<i class="form-group__bar"></i>
								</div>
							</div> 
						</div> 

						<br/>	

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>date</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-xs-12 inputGroupContainer date-input">
									<input type="text" class="form-control" name="id_exp" value="{{ old('id_exp') }}" />
									<span class="input-group-btn">
										<button type="button" class="btn btn-default stbtn" data-toggle="datepicker2" data-target-name="id_exp" style="margin-left: 267px; margin-top: -33px;"><i class="fa fa-calendar" aria-hidden="true"></i> </button> 
									</span> 
									<span class="help-block">
										<strong>{{ $errors->first('id_exp') }}</strong>
									</span>
								</div>
							</div> 
						</div> 

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Image</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-xs-12 inputGroupContainer"> 
									<label for="file-upload1" class="custom-file-upload"> <i class="fa fa-cloud-upload"></i> Upload File </label>
										<img id="doc1" width="100px"  height="100px" class="img-responsive" />
									<input id="file-upload1" name='blog_image' type="file"  style="display:none;">
								</div>

									@if ($errors->has('blog_image'))
									<span class="help-block">
										<strong>{{ $errors->first('blog_image') }}</strong>
									</span>
									@endif
							</div>
						</div>
			
						<div class="form-group">
							<button type="submit" name="edit" class="btn btn-light"><i class=""></i> Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>


	<script>
		$('[data-toggle=datepicker2]').each(function() {
			var target = $(this).data('target-name');
			var t = $('input[name=' + target + ']');
			t.datepicker({
				format: 'yyyy-mm-dd',
				startDate: '-1y',
				autoclose: true
			});
			$(this).on("click", function() {
				t.datepicker("show");
			});
		});
	</script>

	@endsection
