	@if(!empty($wallet['BTC']))
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>BTC Address</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="from_address" class="form-control" value="{{ $wallet['BTC']['address'] }}" readonly><i class="form-group__bar"></i> 
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>BTC Available Balance</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="balance" class="form-control" value="{{ number_format(userBalance($userdetails->id,'BTC'),8) }}" readonly><i class="form-group__bar"></i>
			</div>
		</div>
	</div>
	<hr/>
	<br/>
	@endif

	@if(!empty($wallet['ETH']))
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>ETH Address</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="from_address" class="form-control" value="{{ $wallet['ETH']['address'] }}" readonly><i class="form-group__bar"></i> 
			</div>
		</div>
	</div> 
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>ETH Available Balance</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="balance" class="form-control" value="{{ number_format(userBalance($userdetails->id,'ETH'),8) }}" readonly><i class="form-group__bar"></i>
			</div>
		</div>
	</div>

	<hr/>
	<br/>


	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>USDT Address</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="from_address" class="form-control" value="{{ $wallet['ETH']['address'] }}" readonly><i class="form-group__bar"></i> 
			</div>
		</div>
	</div> 
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>USDT Available Balance</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="balance" class="form-control" value="{{ number_format(userBalance($userdetails->id,'USDT'),8) }}" readonly><i class="form-group__bar"></i>
			</div>
		</div>
	</div>
	<hr/>
	<br/>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>DAI Address</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="from_address" class="form-control" value="{{ $wallet['ETH']['address'] }}" readonly><i class="form-group__bar"></i> 
			</div>
		</div>
	</div> 
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>DAI Available Balance</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="balance" class="form-control" value="{{ number_format(userBalance($userdetails->id,'DAI'),8) }}" readonly><i class="form-group__bar"></i>
			</div>
		</div>
	</div>
	<hr/>
	<br/>
	@endif
	@if(!empty($wallet['LTC']))
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>LTC Address</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="from_address" class="form-control" value="{{ $wallet['LTC']['address'] }}" readonly><i class="form-group__bar"></i> 
			</div>
		</div>
	</div> 
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>LTC Available Balance</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="balance" class="form-control" value="{{ number_format(userBalance($userdetails->id,'LTC'),8) }}" readonly><i class="form-group__bar"></i>
			</div>
		</div>
	</div>
	<hr/>
	<br/>
	@endif
	@if(!empty($wallet['XRP']))
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>XRP Address</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="from_address" class="form-control" value="{{ $wallet['XRP']['address'] }}" readonly><i class="form-group__bar"></i> 
			</div>
		</div>
	</div> 
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>XRP Available Balance</label>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="balance" class="form-control" value="{{ number_format(userBalance($userdetails->id,'XRP'),8) }}" readonly><i class="form-group__bar"></i>
			</div>
		</div>
	</div>
	<hr/>
	<br/>
	@endif
	<h4>Balance Update</h4>
	<form action="{{ url('/admin/update_wallet') }}" method="POST">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label>Coin/Currency</label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<select class="form-control" name="coin">
						<option value="" >Select coin/currency</option>
						@foreach ($coins as $value)
						<option value="{{ $value->source }}">{{ $value->source }}</option>
						@endforeach
					</select>
					@if ($errors->has('coin'))
					<span class="help-block error-msg">
						<strong>{{ $errors->first('coin') }}</strong>
					</span>
					@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label>Amount </label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input type="number" name="amount" class="form-control" value="" step="0.00001" min="0" max="100000000"><i class="form-group__bar"></i>
					<input type="hidden" name="uid" value="{{$uid}}">
					@if ($errors->has('amount'))
					<span class="help-block error-msg">
						<strong>{{ $errors->first('amount') }}</strong>
					</span>
					@endif
				</div>
			</div>
		</div>
		<input class="btn btn-success btn-xs" type="submit" name="submit" value="Update">
	</form>
