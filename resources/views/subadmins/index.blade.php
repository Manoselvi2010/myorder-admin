@extends('layouts.header')
@section('title', 'Sub Admin')
@section('content')
<section class="content">
  <div class="content__inner">
    <header class="content__title"><h1>Sub Admin</h1></header>
    @include('errors.success')  
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
          <h4 class="card-title">Sub Admin</h4>
          <a href="{{ route('subadmins.add') }}" class="btn btn-info" style="float: right; margin-top: -50px;">Add New</a>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Created Date</th>
                    <th>Email</th>
                    <th>Access Permission</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody> 
                  @forelse ($subadmins as $key => $subadmin)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $subadmin->created_at}}</td>
                      <td>{{ $subadmin->email}}</td>
                      <td>{{ $subadmin->role}}</td>
                      <td>
                        <a href="{{ route('subadmins.edit',$subadmin->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('subadmins.destroy',$subadmin->id) }}" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                  @empty
                    <tr><td>No Records</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection