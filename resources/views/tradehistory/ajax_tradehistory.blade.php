<div class="table-responsive" style="overflow-x: auto;white-space: nowrap;">
	@if(count($trades) > 0)
		<table class="table" id="dows">
			<thead>
				<tr>
					<th>Date / Time</th>
					<th>User Name</th>
					<th>Price ({{ $tradepair->cointwo }})</th>
					<th>Amount ({{ $tradepair->coinone }}) </th>
					<th>Remaining ({{ $tradepair->cointwo }}) </th> 
					<th>Total ({{ $tradepair->cointwo }}) </th>
					<th>Trade Fee ({{ $tradepair->cointwo }}) </th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			   
				@foreach($trades as $trade) 
				<tr>
					<td>{{ date('d/m/Y', strtotime($trade->created_at)) }}</td>
					<td>{{ username($trade->uid) }}</td>
					<td>{{ number_format($trade->price, 8, '.', '') }}</td>
					<td>{{ number_format($trade->volume, 8, '.', '') }}</td>
					<td>{{ number_format($trade->remaining, 8, '.', '') }}</td> 
					<td>{{ number_format($trade->value, 8, '.', '') }}</td>
					<td>{{ number_format($trade->fees, 8, '.', '') }}</td>
					<td>
						@if($trade->status == 0 ) 
							Pending 
						@elseif($trade->status == 100 ) 
							Cancelled
						@else 
							Completed 
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else 
			<div class="alert alert-info">Yet no trades available</div>
		@endif
	</div>
		@if($type == "Buy")
		<div class="sets" style="float:right;font-size: 16px;">
			<span class="col-md-4 col-sm-6">Total Spent : {{ $total->sum('value')+$total->sum('fees') }} {{ $tradepair->cointwo }}</span><span class="col-md-4 col-sm-6">Trade Received : {{ $total->sum('volume') }} {{ $tradepair->coinone }}</span>
		</div>
		@else
		<div class="sets" style="float:right;font-size: 16px;">
			<span class="col-md-4 col-sm-6">Total Spent : {{ $total->sum('volume')+$total->sum('fees') }} {{ $tradepair->coinone }}</span><span class="col-md-4 col-sm-6">Trade Received : {{ $total->sum('value') }} {{ $tradepair->cointwo }}</span>
		</div>
		@endif
	<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
<div class="pagination-tt clearfix">
    @if($trades->count())
    {{ $trades->links() }}
@endif
</div>
</div>