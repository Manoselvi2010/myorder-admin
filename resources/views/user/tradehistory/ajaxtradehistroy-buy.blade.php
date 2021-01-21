<div class="table-responsive search_result">
  <table class="table" style="background-color: #1a417d;">
    <thead>
      <tr>
        <th>Date & Time</th>
        <th>Pair</th>
        <th>Order Type</th>
        <th>Price</th>
        <th>Amount</th>
        <th>Remaining</th>
        <th>Fee</th>
        <th>Total</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody class="site-table">
      @if( count($buytrades) > 0 )
      @foreach($buytrades as $buytrade)
      <tr>
        <td>{{$buytrade->created_at}}</td>
        <td>{{$buytrade->coinone}} / {{$buytrade->cointwo}}</td>
        <td>{{ $buytrade->order_type == 1 ? 'Limit':'Market'}}</td>
        <td>{{ $buytrade->order_type == 1 ? number_format($buytrade->price, 8) : '-' }}</td>
        <td>{{number_format($buytrade->volume,8)}}</td>
        <td>{{number_format($buytrade->remaining,8)}}</td>  
        <td>{{number_format($buytrade->fees,8)}}</td>
        <td>{{ $buytrade->order_type == 1 ? number_format($buytrade->value, 8) : '-' }}</td>
        <td>
          @if($buytrade->status==0)
          {{'Pending'}}
          @elseif($buytrade->status==1)
          {{'Completed'}}
          @else
          {{'Cancelled'}}
          @endif
        </td>
      </tr>
      @endforeach
      @else
      <tr>
        <td colspan="9" > No Records Found </td>
      </tr> 
      @endif
    </tbody>
  </table>
</div>