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
      @if( count($selltrades) > 0 )
      @foreach($selltrades as $selltrade)
      <tr>
        <td>{{$selltrade->created_at}}</td>
        <td>{{$selltrade->coinone}} / {{$selltrade->cointwo}}</td>
        <td>{{ $selltrade->order_type == 1 ? 'Limit':'Market'}}</td>
        <td>{{ $selltrade->order_type == 1 ? number_format($selltrade->price, 8) : '-' }}</td>
        <td>{{number_format($selltrade->volume,8)}}</td>
        <td>{{number_format($selltrade->remaining,8)}}</td>  
        <td>{{number_format($selltrade->fees,8)}}</td>  
        <td>{{ $selltrade->order_type == 1 ? number_format($selltrade->value, 8) : '-'}}</td>
        <td>
          @if($selltrade->status==0)
          {{'Pending'}}
          @elseif($selltrade->status==1)
          {{'Completed'}}
          @else
          {{'Cancelled'}}
          @endif
        </td>
      </tr>
      @endforeach
      @else
      <tr>
        <td colspan="8" > No Records Found </td>
      </tr> 
      @endif
    </tbody>
  </table>
</div>