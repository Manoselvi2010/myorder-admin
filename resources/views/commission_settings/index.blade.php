@extends('layouts.header')
@section('title', 'Commission Settings')
@section('content')
<section class="content">
  <header class="content__title"><h1>Commission Settings</h1></header>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Commission Settings </h4>
          <a href="{{ route('commission_settings.create') }}" class="btn btn-info" style="float: right; margin-top: -50px;">Add New ERC-20 Tokens</a>
          <div class="table-responsive"> 
            @if(count($commissions))
            <table class="table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Coin / Currency</th>
                  <th>Withdraw Commission</th>
                  <th>Trade Buy Commission</th>
                  <th>Trade Sell Commission</th>
                  <th>Net Fee</th>
                  <th >Description</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody> 
              @foreach($commissions as $key => $commission)
                @if($commission->type == 'coin')
                  @php $decimal = 5; @endphp
                @else
                  @php $decimal = 2; @endphp
                @endif
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $commission->source }}</td>
                  <td>{{ number_format($commission->withdraw, $decimal, '.', '') }}</td>
                  <td>{{ number_format($commission->buy_trade, $decimal, '.', '') }}</td>
                  <td>{{ number_format($commission->sell_trade, $decimal, '.', '') }}</td>
                  <td>{{ ($commission->net_fee)?$commission->net_fee:0 }}</td>                    
                  <td style="box-sizing: content-box;"> {{strip_tags($commission->description)}} </td>
                  <td><a href="{{ route('commission_settings.edit', Crypt::encrypt($commission->id)) }}" class="btn btn-info">View / Edit</a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
            {{ $commissions->links() }}
            @else
              {{ 'No Commissions Settings' }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection