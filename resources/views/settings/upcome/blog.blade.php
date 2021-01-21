@extends('layouts.header')
@section('title', 'Commission Settings')
@section('content')
<section class="content">
  <div class="content__inner">
    <header class="content__title">
    </header>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
          <h4 class="card-title">Upcome Settings </h4>
          <!-- <a href="{{ url('admin/news_add') }}" class="btn btn-info" style="float: right; margin-top: -50px;">ADD</a> -->
            <div class="table-responsive">

                @if(session('status'))
  <div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> {{ session('status') }}
  </div>
  @endif
           
              @if(count($faq))
              <table class="table">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody> 
                @foreach($faq as $key => $commission)
                 
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td><img src="{{ url($commission->image) }}" width="150px" height="100px" /></td>
                    <td>{{ $commission->created_at }}</td>
                    <td>
                      <a href="{{ url('admin/upcomming/'.$commission->id) }}" class="btn btn-info">View / Edit</a>
                      <!-- <a href="{{ url('admin/news_delete/'.$commission->id) }}" class="btn btn-danger">Delete</a> -->
                    </td>
                    
                  </tr>
                @endforeach
                </tbody>
              </table>
              {{ $faq->links() }}
              @else
                {{ 'No Blog Found' }}
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection