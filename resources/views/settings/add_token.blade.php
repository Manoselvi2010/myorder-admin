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
        <form method="POST" action="{{ url('admin\save_token') }}">
        {{ csrf_field() }} 
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Name</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" name="name" class="form-control" >
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
                <input type="text" name="contract_address" class="form-control" >
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
                <input type="text" name="abi_array" class="form-control" >
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
                <input type="text" name="decimals" class="form-control" >
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
                <input type="text" name="gas_price" class="form-control" >
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
  