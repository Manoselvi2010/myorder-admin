@extends('layouts.header')
@section('title', 'Commission Settings')
@section('content')
<section class="content">
	<header class="content__title"><h1>Commission Settings</h1></header>
  	@include('errors.success')  
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<a href="{{ route('commission_settings.index') }}"><i class="zmdi zmdi-arrow-left"></i> Back to Commission</a>
					<br /><br />
					<form method="post" action="{{ route('commission_settings.store') }}" autocomplete="off">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Source</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="source" class="form-control" value="" required="required" />
									<i class="form-group__bar"></i>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Coin / Currency Name</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="currency" class="form-control" value="" required="required"/><i class="form-group__bar"></i>
								</div>
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
									<input type="text" name="contract" class="form-control" value="" required="required"/><i class="form-group__bar"></i>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Trade Buy Commission (%)</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="trade" class="form-control dot digits" value="" required="required"/><i class="form-group__bar"></i>
									@if ($errors->has('trade'))
					                    <span class="help-block">
					                        <strong>{{ $errors->first('trade') }}</strong>
					                    </span>
				                	@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Trade Sell Commission (%)</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="sell" class="form-control dot digits" value="" required="required"/><i class="form-group__bar"></i>
									@if ($errors->has('sell'))
					                    <span class="help-block">
					                        <strong>{{ $errors->first('sell') }}</strong>
					                    </span>
				                	@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Withdraw Commission (%)</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="withdraw" class="form-control dot digits" value="" required="required"/><i class="form-group__bar"></i>
									@if ($errors->has('withdraw'))
					                    <span class="help-block">
					                        <strong>{{ $errors->first('withdraw') }}</strong>
					                    </span>
					                @endif
								</div>
							</div> 
						</div> 
				
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Net Fee</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="netfee" class="form-control dot digits" value="" required="" required="required"/><i class="form-group__bar"></i>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-md-3">Description</label>
							<div class="col-md-7">
							   	<textarea class="ckeditor" name="description" required=""></textarea>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-light">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
