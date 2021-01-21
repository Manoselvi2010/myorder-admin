@if($history->count())
<table class="table" id="dows">
	<thead>
		<tr>
			<th>S.No</th>
			<th>User Name</th>
			<th>Recipient</th>
			<th>Sender</th>
			<th>Amount</th>
			<th>Action</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody> 
	@foreach($history as $key => $histories)
		<tr>
			<td>{{ $key+1 }}</td>
			<td><a href="{{ url('admin/users_edit/'.Crypt::encrypt($histories->user_id)) }}">{{ username($histories->user_id) }}</a></td>
			<td>{{ $histories->recipient }}</td>
			<td>{{ $histories->sender }}</td>
			<td>{{ $histories->amount }}</td>
			<td>@if($histories->status == 1)
				@if($histories->type == 'received')
		     		Pending
		     	@else
		     	<button class="btn btn-success" onclick="status('{{ $histories->id }}','{{ $pair}}','{{ $histories->recipient }}','{{ $histories->sender }}','{{ $histories->amount }}',' {{ $histories->type }}')"  data-toggle="modal" data-target="#myModal">Pending</button>
		     	@endif
			    @elseif($histories->status == 2)
			    	Approved
			    @else
			      	Rejected
			    @endif
			</td>
			<td>{{ date('m-d-Y', strtotime($histories->created_at)) }}</td>
			</td>
		</tr> 
	@endforeach
	</tbody>
</table>
@else 
	{{ 'No record found! ' }}
@endif
<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
<div class="pagination-tt clearfix">
@if($history->count())
    {{ $history->links() }}
@endif