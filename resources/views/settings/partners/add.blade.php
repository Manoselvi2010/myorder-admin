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
				<div class="card-header">
					<a href="{{ route('news.index') }}"><i class="zmdi zmdi-arrow-left"></i> Back to New</a>
				</div>
				<div class="card-body">
					<form method="post" action="{{ route('news.store') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="row form-group">
							<label class="col-md-3">Title</label>
							<div class="col-md-4">
								<input type="text" name="title" class="form-control" value=""><i class="form-group__bar"></i>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-md-3">Description</label>
							<div class="col-md-7">
								<textarea name="description" class="form-control" style="line-height: 10px;" rows=15></textarea>
							</div> 
						</div>
						<div class="row form-group">
							<label class="col-md-3">Image</label>
							<div class="col-md-4">
								<div class="col-xs-12 inputGroupContainer"> 
									<label for="file-upload1" class="custom-file-upload"> <i class="fa fa-cloud-upload"></i> Upload File </label>
									<img id="doc1" width="100px"  height="100px" class="img-responsive" />
									<input id="file-upload1" name='image' type="file"  style="display:none;">
								</div>
								@if ($errors->has('blog_image'))
									<span class="help-block">
										<strong>{{ $errors->first('blog_image') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="row form-group">
	                        <label class="col-sm-4 col-lg-3">Status</label>
	                        <div class="col-sm-4 col-lg-4">
                                <select class="form-control" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
	                        </div>
	                    </div> 
						<div class="row form-group">
							<div class="col-md-12" align="center">
								<button type="submit" name="edit" class="btn btn-light"><i class=""></i> Update</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
