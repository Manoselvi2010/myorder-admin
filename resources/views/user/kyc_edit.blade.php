@extends('layouts.header')
@section('title', 'Users List - Admin')
@section('content')
<section class="content">
  <div class="content__inner">
    <header class="content__title">
      <h1>KYC Submit</h1>
    </header>
    @if(session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
    @endif

    @if(session('fail'))
        <div class="alert alert-danger">
          {{ session('fail') }}
        </div>
    @endif
    
    <div class="card">
      <div class="card-body">
        <a href="{{ url('admin/kyc') }}">Back to kyc</a>
        <br>
        <br>
        <form method="POST" action="{{ url('admin/kycupdate') }}">
        {{ csrf_field() }}
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>First Name</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="fromaddress" class="form-control" value="{{ $kyc->fname }}" readonly>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Last Name</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="fromaddress" class="form-control" value="{{ $kyc->lname }}" readonly>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Date of Birth</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="fromaddress" class="form-control" value="{{ $kyc->dob }}" readonly>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>State/City</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="fromaddress" class="form-control" value="{{ $kyc->city }}" readonly>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Country</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="fromaddress" class="form-control" value="{{ country_name($kyc->country)->name }}" readonly>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>ID Type</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="fromaddress" class="form-control" value="{{ $kyc->id_type }}" readonly>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>ID Number</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="fromaddress" class="form-control" value="{{ $kyc->id_number }}" readonly>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>ID Expiry Date</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="fromaddress" class="form-control" value="{{ $kyc->id_exp  }}" readonly>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Address</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="fromaddress" class="form-control" value="{{ $kyc->address  }}" readonly>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>ID Proof (Front)</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <a href="{{ $url.$kyc->front_img }}" target="_blank"> 
                    <img width="200px" src="{{ $url.$kyc->front_img }}">
                </a>
                 </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>ID Proof (Back)</label>
              </div>
            </div>
          
            <div class="col-md-4">
              <div class="form-group">
                <a href="{{ $url.$kyc->back_img }}" target="_blank">
                    <img width="200px" src="{{ $url.$kyc->back_img }}"> 
                </a>
             </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Status</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                @if($kyc->status == 2) 
                  <select class="form-control" name="status">
                    <option value="2">Waiting</option>
                    <option value="1">Accepted</option>
                    <option value="3">Rejected</option>
                  </select> 
              @else
                 @if($kyc->status == 1)
                    Accepted
                 @else
                    Rejected
                 @endif
              @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>&nbsp;</label>
              </div>
            </div>
            @if($kyc->status == 2)
            <div class="col-md-4">
               <input type="hidden" name="kyc_id" value="{{ $kyc->id }}"/>
               <input type="hidden" name="uid" value="{{ $kyc->user_id }}"/>
               <button class="btn btn-md btn-warning" type="submit"> Update</button><br /><br />
               <p>Note : Once you accept / reject kyc, you can't update again!</p>
            </div>
            @endif
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
  @endsection
  