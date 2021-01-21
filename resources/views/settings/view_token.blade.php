@extends('layouts.header')
@section('title', 'ERC 20 Tokens - Admin')
@section('content')
<section class="content">
  <div class="content__inner">
    <header class="content__title">
      <h1>ERC 20 Tokens Settings</h1>
    </header>
    @include('layouts.message')
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ url('admin\update_token') }}">
        {{ csrf_field() }} 
        <input type="hidden" name="id" value="{{ $details->id }}">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Name</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="name" class="form-control" value="{{ $details->name }}">
                <i class="form-group__bar"></i> </div>
            </div>
          </div>   
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Contract Address</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="contract_address" class="form-control" value="{{ $details->contract_address }}">
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>ABI Array</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="abi_array" class="form-control" value="{{ $details->abi_array }}">
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Decimals</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="decimals" class="form-control" value="{{ $details->decimals }}">
                <i class="form-group__bar"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Gas Price</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="gas_price" class="form-control" value="{{ $details->gas_price }}">
                <i class="form-group__bar"></i> </div>
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
               <select name="status">
                 <option value="1" {{($details->status == 1)?'selected':''}}>Enable</option>
                 <option value="0" {{($details->status == 0)?'selected':''}}>Disable</option>
               </select>
                <i class="form-group__bar"></i> </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>&nbsp;</label>
              </div>
            </div>
            <div class="col-md-4">
               <button class="btn btn-md btn-warning" type="submit"> Add</button><br /><br />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
  