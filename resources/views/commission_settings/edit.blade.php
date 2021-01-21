@extends('layouts.header')
@section('title', 'Commission Settings')
@section('content')
<section class="content">
	<header class="content__title">
		<h1>Commission Settings</h1>
	</header>
	@if(session('status'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> {{ session('status') }}
        </div>
    @endif
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<a href="{{ route('commission_settings.index') }}"><i class="zmdi zmdi-arrow-left"></i> Back to Commission</a>
					<br /><br />
					<form method="post" action="{{ route('commission_settings.update') }}" autocomplete="off">
						{{ csrf_field() }}
						<input type="hidden" value="{{ $commission->id }}" name="id">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Coin / Currency</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="currency" class="form-control" value="{{ $commission->source}}" readonly/><i class="form-group__bar"></i>
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
									<input type="text" name="withdraw" class="form-control dot digits" value="{{ number_format($commission->withdraw,$digit,'.','') }}"/><i class="form-group__bar"></i>
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
									<label>Trade Buy Commission (%)</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="trade" class="form-control dot digits" value="{{ number_format($commission->buy_trade,$digit,'.','')}}"/><i class="form-group__bar"></i>
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
									<input type="text" name="sell" class="form-control dot digits" value="{{ number_format($commission->sell_trade,$digit,'.','') }}"/><i class="form-group__bar"></i>
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
									<label>Net Fee</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="netfee" class="form-control dot digits" value="{{ ($commission->net_fee)?$commission->net_fee:0 }}" /><i class="form-group__bar"></i>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-md-3">Description</label>
							<div class="col-md-7">
							   	<textarea class="ckeditor" name="description">
							   		{{$commission->description}}
							   	</textarea>
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
	<script>
	  $('.digits').on('input', function() {
	    if('{{ $commission->source}}' == 'USD')
	    {
	      this.value = this.value
	      .replace(/(\.[\d]{2})./g, '$1');
	    }
	    else
	    {
	      this.value = this.value
	      .replace(/(\.[\d]{5})./g, '$1');
	    }
	});
	</script>
	@endsection
