<table class="table" id="dows">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Date</th>
      <th>User Name</th>
      <th>Coin</th>
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
        <td>{{ date('d-m-Y',strtotime($value->created_at)) }}</td>
        <td><a href="{{ url('admin/users_edit/'.Crypt::encrypt($value->uid)) }}">{{ username($value->uid) }}</a></td>
        <td>{{ $pair }}</td>
        <td>@if($type_ref == 'deposit')
              <img src="{{ $value->proof }}" width="10%" />
            @else
            @endif  
          </td>
        <td>{{ $value->amount }}</td>
        <td>
          @if($value->status == 0)
              <button class="btn btn-success" onclick="status('{{ $value->id }}','{{ $pair}}','{{ $value->recipient }}','{{ $value->sender }}','{{ $value->amount }}',' {{ $type_ref }}')"  data-toggle="modal" data-target="#myModal">Pending</button>
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
{{ $history->links() }}