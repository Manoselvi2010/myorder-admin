@extends('layouts.header')
@section('title', 'under maintenance')
@section('content')
<section class="content">
  <header class="content__title"><h1>Undermaintenance</h1></header>
  @include('errors.success')  
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          @if(isset($setting))
            <form method="post" action="{{route('under_maintenance.update', $setting->id)}}">
          @else
            <form method="post" action="{{route('under_maintenance.update')}}">
          @endif
            {{ csrf_field() }}
            <div class="row">
              <label class="col-sm-4 col-lg-3">Under Maintenance</label>
              <div class="col-sm-7 col-lg-7">
                <select class="form-control" name="site_status" required>
                  <option value="">Select Status</option>
                  <option value="0" <?php if(isset($setting)){ if($setting->site_status=="0"){ ?> selected <?php } }?>>Disable</option>
                  <option value="1" <?php if(isset($setting)){if($setting->site_status=="1"){?> selected <?php } }?>>Enable</option>
                </select>
              </div>
            </div> 
            <div class="row">
              <label class="col-md-3 form-group">Description</label>
              <div class="col-md-7 form-group">
                <textarea name="description" class="form-control" style="line-height: 10px;" rows=15>@if(isset($setting)){{ $setting->description}}@endif</textarea>
              </div> 
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-light">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
