@extends('layouts.header')
@section('title', 'SECURITY SETTING')
@section('content')
<section class="content">
<div class="content__inner">
  <header class="content__title"><h1>Security Setting</h1></header>
  @include('layouts.message')  
  <div class="card">
    <div class="card-body"> 
      <form method="post" action="{{ route('security_settings.change_email') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="row form-group">
          <label class="col-md-3">Email</label>
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" name="email" placeholder="Enter Email" class="form-control" value="{{$admin->email}}">
              <strong class="text-danger">{{ $errors->first('email') }}</strong>
              <i class="form-group__bar"></i> </div> 
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-3">
            <button type="submit" class="btn btn-light">Submit</button>
          </div>
        </div>
      </form>
      <hr />
      <form method="post" action="{{ route('security_settings.change_password') }}" autocomplete="off">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{$admin->id}}">
        <div class="row form-group">
          <label class="col-md-3">Current Password</label>
          <div class="col-md-4">
            <input type="password" name="oldpassword"  placeholder="Old Password" id="site_title" class="form-control" value="">
            <strong class="text-danger">{{ $errors->first('oldpassword') }}</strong>
            <i class="form-group__bar"></i> 
          </div> 
        </div>
        <div class="row form-group">
          <label class="col-md-3">New Password</label>
          <div class="col-md-4">
            <input type="password" name="newpassword"  placeholder="New Password" class="form-control" value="">
            <strong class="text-danger">{{ $errors->first('newpassword') }}</strong>
            <i class="form-group__bar"></i> 
          </div> 
        </div>
        <div class="row form-group">
          <label class="col-md-3">Confirm New Password</label>
          <div class="col-md-4">
            <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" >
            <strong class="text-danger">{{ $errors->first('confirmpassword') }}</strong>
            <i class="form-group__bar"></i> 
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-light">Change Password</button>
        </div>
      </form>
    </div>
  </div>
</div>
</section>
@endsection