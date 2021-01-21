@extends('layouts.header')
@section('title', ' Admin Withdraw History')
@section('content')
<section class="content">
	<div class="card">
		<div class="card-body conts">
			<div class="row">
				<div class="col-md-12">
					<h5 class="text-uppercase maginf">Admin {{ $coin }} Withdraw History</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-12 tg-select"> 
					<select onchange="location = this.value;" class="form-control custom-s"> 
                        <option value="{{ url('admin/btc_withdrawhistory') }}" @if($coin == 'BTC') {{ 'selected' }} @endif>BTC</option> 
                        <option value="{{ url('admin/eth_withdrawhistory') }}" @if($coin == 'ETH') {{ 'selected' }} @endif >ETH</option> 
                        <option value="{{ url('admin/ltc_withdrawhistory') }}" @if($coin == 'LTC') {{ 'selected' }} @endif >LTC</option> 
                        <option value="{{ url('admin/xrp_withdrawhistory') }}" @if($coin == 'XRP') {{ 'selected' }} @endif >XRP</option> 
                        <option value="{{ url('admin/linear_withdrawhistory') }}" @if($coin == 'LINEAR') {{ 'selected' }} @endif >LINEAR</option> 
                         <option value="{{ url('admin/usd_withdrawhistory') }}" @if($coin == 'USD') {{ 'selected' }} @endif >USD</option> 
                  </select>
				</div>
			</div>
			<div class="tab-content">
				<div id="buyo" class="tab-pane fade in active show">
					<div class="table-responsive" style="overflow-x: auto;white-space: nowrap;">
					@if($history->count())
						<table class="table" id="dows">
							<thead>
								<tr>
									<th>Date / Time</th> 
									<th>Sender</th>
									<th>Recipient</th>
									<th>Amount</th>
									<th>TxID</th>  
								</tr>
							</thead>
							<tbody>
								@foreach($history as $trade) 
									<tr>
										<td>{{ date('d/m/Y H:i:s A', strtotime($trade->created_at)) }}</td> 
										<td>{{ $trade->sender }}</td>
										<td>{{ $trade->recipient }}</td>
										<td>{{ number_format($trade->amount, 8, '.', '') }}</td>
										<td>{{ $trade->txid }}</td> 
									</tr>
								@endforeach
							</tbody>
						</table>
						@else 
							<div class="alert alert-info">No record found</div>
						@endif
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="pagination-tt clearfix">
                    @if($history->count())
				    {{ $history->links() }}
				@endif
                </div>
              </div>
				</div>
			</div>
		</div>
	</div>

@endsection
<script>
    function pageredirect(self){
	window.location.href = self.value;
}
</script>