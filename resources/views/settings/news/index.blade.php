@extends('layouts.header')
@section('title', 'Users List - Admin')
@section('content')
<section class="content">
  <header class="content__title"><h1>News</h1></header>
  @include('errors.success')
  <div class="row">
    <div class="col-md-12">  
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Sub Admin</h4>
          <a href="{{ route('news.add') }}" class="btn btn-info" style="float: right; margin-top: -50px;">Add New</a>
          <div class="table-responsive search_result">
            @if($news->count())
            <table class="table" id="dows">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($news as $key => $content)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $content->title }}</td>
                  <td>{{ $content->description }} </td>
                  <td> <img src="{{ url('storage/app/public/news/'.$content->image) }}" height="50px" style="margin-top: 5px;" /></td>
                  <td>
                    @if($content->status == 1)
                        Active
                    @else
                        Inactive
                    @endif
                  </td>
                  <td>
                    <a class="btn btn-success btn-xs" href="{{ route('news.edit',$content->id) }}"><i class="zmdi zmdi-edit"></i> View </a>
                    <a class="btn btn-danger btn-xs" href="{{ route('news.destroy',$content->id) }}"><i class="zmdi zmdi-danger"></i> Delete </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else 
            {{ 'No record found! ' }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection


