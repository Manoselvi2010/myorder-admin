@extends('layouts.header')
@section('title', 'news Settings')
@section('content')
<section class="content">
  <header class="content__title"><h1>Blog Settings</h1></header>
  @if(session('status'))
    <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>Success!</strong> 
      {{ session('status') }}
    </div>
  @endif
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <a href="{{ route('news.index') }}"><i class="zmdi zmdi-arrow-left"></i> Back to Blog</a>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('news.update') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $news->id }}" name="id">
            <div class="row">
              <label class="col-md-3 form-group">Title</label>
              <div class="col-md-4 form-group">
                <input type="text" name="title" class="form-control" value="{{ $news->title}}"><i class="form-group__bar"></i>
              </div>
            </div>
            <div class="row">
              <label class="col-md-3 form-group">Description</label>
              <div class="col-md-7 form-group">
                <textarea name="description" class="form-control" style="line-height: 10px;" rows=15>{{ $news->description}}</textarea>
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
                  <img id="doc1" width="100px"  height="100px" class="img-responsive" src="{{ url('storage/app/public/news/'.$news->image) }}" />
                  <input id="file-upload1" name='blog_image' type="file"  style="display:none;">
                </div>
                @if ($errors->has('blog_image'))
                <span class="help-block">
                  <strong>{{ $errors->first('blog_image') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="row">
              <label class="col-sm-4 col-lg-3">Status</label>
              <div class="col-sm-8 col-lg-9">
                <select class="form-control" name="status" required>
                  <option value="">Select Status</option>
                  <option value="0" <?php if($news->status=="0"){?> selected <?php } ?>>Inactive</option>
                  <option value="1" <?php if($news->status=="1"){?> selected <?php } ?>>Active</option>
                </select>
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
@endsection
