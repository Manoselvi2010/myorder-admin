<div class="table-responsive search_result">
<table class="table" style="background-color: #1a417d;">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Date & Time</th>
      <th>Currency</th>
      <th>{{ ($type_ref == 'deposit')?'Proof':'' }}</th>
      <th>Amount</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
  @if(count($history)>0)
    @foreach ($history as $key => $value)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ date('d-m-Y H:i:s',strtotime($value->created_at)) }}</td>
        <td>{{ $pair }}</td>
    
        <td>
          @if($type_ref == 'deposit')
            <a href="{{ $value->proof }}" target="_blank"><img src="{{ $value->proof }}" width="100px" /></a>
          @endif
        </td>
        
        <td>{{ $value->amount }}</td>
        <td>
          @if($value->status == 0)
            Pending
          @elseif($value->status == 2)
            Success
          @else
            Admin Cancelled
          @endif
        </td>
      </tr>
    @endforeach
  @else
    <tr>
      <td colspan="6" align="center">No Records Found</td>
    </tr>
  @endif
  </tbody>
</table>
</div>
{{ $history->links() }}