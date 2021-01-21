<div class="table-responsive search_result">
<table class="table" style="background-color: #1a417d;">
  <thead>
    <tr>
      <th >S.No</th>
      <th >Date & Time</th>
      <th >Coin</th>
      <th >Recipient</th>
      <th >Sender</th>
      <th >Amount</th>
      <th >Status</th>
    </tr>
  </thead>
  <tbody>
  @if(count($history)>0)
    @foreach ($history as $key => $value)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ date('d-m-Y H:i:s',strtotime($value->created_at)) }}</td>
        <td>{{ $pair }}</td>
        <td>{{ $value->recipient }}</td>
        <td>{{ $value->sender }}</td>
        <td>{{ $value->amount }}</td>
        <td>
          @if($value->status == 1)
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
      <td colspan="7" align="center" style="color: white;">No Records Found</td>
    </tr>
  @endif
  </tbody>
</table>
</div>
{{ $history->links() }}