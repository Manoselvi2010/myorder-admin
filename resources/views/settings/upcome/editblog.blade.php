@extends('layouts.header')
@section('title', 'Upcomming Settings')
@section('content')
<section class="content">
	<header class="content__title">
		<h1>Upcomming Settings</h1>
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
					<a href="{{ url('admin/upcomming') }}"><i class="zmdi zmdi-arrow-left"></i> Back to Upcome</a>
					<br /><br />
					<form method="post" action="{{ url('admin/upcomming_update') }}" enctype="multipart/form-data" autocomplete="off">
						{{ csrf_field() }}
						<input type="hidden" value="{{ $commission->id }}" name="id">

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
				startDate: '+1d',
				autoclose: true
			});
			$(this).on("click", function() {
				t.datepicker("show");
			});
		});
	</script>
	<script>
		$('.digits').on('input', function() {
			if('{{ $commission->source}}' == 'USD')
			{
				this.value = this.value
				.replace(/(\.[\d]{2})./g, '$1');
			}
			else
			{
				this.value = this.value
				.replace(/(\.[\d]{5})./g, '$1');
			}
		});
	</script>
	@endsection
