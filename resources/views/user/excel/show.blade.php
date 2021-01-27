@extends('layouts.header')
@section('title', 'User Detail')
@section('content')
<?php $user_url = config('app.user_url'); ?>
<section class="content">
  <header class="content__title"><h1>User Details</h1></header>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <ul class="excellistf">
       <!--  <li>
          <a href="{{route('excel.export',[$user_detail['id'],'xls'])}}"><span class="btn btn-success user_date"> <i class="zmdi zmdi-download zmdi-hc-fw"></i> xls</span></a>
        </li> -->
        <li>
          <a href="{{route('excel.export',[$user_detail['id'],'pdf'])}}"><span class="btn btn-success user_date"> <i class="zmdi zmdi-download zmdi-hc-fw"></i> pdf</span></a>
        </li>
        <li>
          <a href="{{route('excel.export',[$user_detail['id'],'csv'])}}"><span class="btn btn-success user_date"> <i class="zmdi zmdi-download zmdi-hc-fw"></i> csv</span></a>
        </li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">        
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Profile Details</h4>
          @if(count($user_detail))
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Full Name :  {{ $user_detail['first_nmae'] }} {{ $user_detail['last_nmae'] }}</label>
                </div>
                <div class="form-group">
                  <label>Email :  {{ $user_detail['email'] }} </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div>
                    @if($user_detail['image'] == null)
                      <img src="{{ $user_url.'/storage/app/public/profile/no-image.jpeg' }}"  class="profileigf"/>
                    @else
                      <img src="{{ $user_url.'/'.$user_detail->image }}" class="profileigf" />
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @else
            {{ 'No Commissions Settings' }}
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">        
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Wallet Details </h4>
          <div class="table-responsive">
            @if(count($user_detail['commission']))
              <table class="table">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Coin / Currency</th>
                    <th>Address</th>
                    <th>Deposit amount</th>
                    <th>trade amount</th>
                    <th>escrow amount</th>
                    <th>Total amount</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user_detail['commission'] as $key => $value)
                  <tr>                  
                    <td>{{ $key+1 }}</td>
                    <td>{{$value}}</td>
                    @if(isset($user_detail[$value.'_address']))
                      <td>{{ $user_detail[$value.'_address'] }}</td>
                    @else
                      <td>-</td>
                    @endif
                    @if(isset($user_detail[$value.'_deposit_balance']))
                      <td>{{ $user_detail[$value.'_deposit_balance'] }}</td>
                    @else
                      <td>-</td>
                    @endif
                    @if(isset($user_detail[$value.'_trade_balance']))
                      <td>{{ $user_detail[$value.'_trade_balance'] }}</td>
                    @else
                      <td>-</td>
                    @endif
                    @if(isset($user_detail[$value.'_escrow_balance']))
                      <td>{{ $user_detail[$value.'_escrow_balance'] }}</td>
                    @else
                      <td>-</td>
                    @endif
                    @if(isset($user_detail[$value.'_total_balance']))
                      <td>{{ $user_detail[$value.'_total_balance'] }}</td>
                    @else
                      <td>-</td>
                    @endif
                  </tr>
                  @endforeach               
                </tbody>
              </table> 
            @else
              {{ 'No Record Found' }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">        
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Buy Trade Details </h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Date / Time</th>
                  <th>Pair</th>
                  <th>Price</th>
                  <th>Amount</th>
                  <th>Remaining</th>
                  <th>Cancelled</th>
                  <th>Total</th>
                  <th>Trade Fee</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @if(count($user_detail['buy_trade']))
                  @foreach($user_detail['buy_trade'] as $key => $buy_value)
                    @php 
                      $cancelled = 0.0000; 
                      $remaining = $buy_value->remaining;
                    @endphp
                    @if($buy_value->status == 2)
                      @php 
                        $cancelled = $buy_value->remaining;
                        $remaining = 0.0000 
                      @endphp
                    @endif
                    <tr>                  
                      <td>{{ $key+1 }}</td>
                      <td>{{ $buy_value->created_at}}</td>
                      <td>{{ $buy_value->pair}}</td>
                      <td>{{ number_format($buy_value->price, 8, '.', '') }}</td>
                      <td>{{ number_format($buy_value->volume, 8, '.', '') }}</td>
                      <td>{{ $remaining}}</td>
                      <td>{{ $cancelled }}</td>
                      <td>{{ number_format($buy_value->value, 8, '.', '') }}</td>
                      <td>{{ number_format($buy_value->fees, 8, '.', '') }}</td>
                      <td>
                        @if($buy_value->status == 0 ) 
                          Pending 
                        @elseif($buy_value->status == 2 ) 
                          Cancelled 
                        @else 
                          Completed 
                        @endif
                      </td>
                    </tr>
                  @endforeach               
                @else
                  <tr><td colspan="10">{{ 'No Record Found' }}</td></tr>
                @endif
              </tbody>   
            </table>       
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">        
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Sell Trade Details </h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Date / Time</th>
                  <th>Pair</th>
                  <th>Price</th>
                  <th>Amount</th>
                  <th>Remaining</th>
                  <th>Cancelled</th>
                  <th>Total</th>
                  <th>Trade Fee</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @if(count($user_detail['sell_trade']))
                  @foreach($user_detail['sell_trade'] as $key => $buy_value)
                    @php 
                      $cancelled = 0.0000; 
                      $remaining = $buy_value->remaining;
                    @endphp
                    @if($buy_value->status == 2)
                      @php 
                        $cancelled = $buy_value->remaining;
                        $remaining = 0.0000 
                      @endphp
                    @endif
                    <tr>                  
                      <td>{{ $key+1 }}</td>
                      <td>{{ $buy_value->created_at}}</td>
                      <td>{{ $buy_value->pair}}</td>
                      <td>{{ number_format($buy_value->price, 8, '.', '') }}</td>
                      <td>{{ number_format($buy_value->volume, 8, '.', '') }}</td>
                      <td>{{ $remaining}}</td>
                      <td>{{ $cancelled }}</td>
                      <td>{{ number_format($buy_value->value, 8, '.', '') }}</td>
                      <td>{{ number_format($buy_value->fees, 8, '.', '') }}</td>
                      <td>
                        @if($buy_value->status == 0 ) 
                          Pending 
                        @elseif($buy_value->status == 2 ) 
                          Cancelled 
                        @else 
                          Completed 
                        @endif
                      </td>
                    </tr>
                  @endforeach               
                @else
                  <tr><td colspan="10">{{ 'No Record Found' }}</td></tr>
                @endif
              </tbody>
            </table>    
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">        
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Deposit Details</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Coin / Currency</th>
                  <th>Recipient</th>
                  <th>Sender</th>
                  <th>Amount</th>
                  <th>Action</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @if(count($user_detail['BTC_deposit_history']))                  
                  @foreach($user_detail['BTC_deposit_history'] as $key => $value)
                    <tr>                  
                      <td>{{ $key+1 }}</td>
                      <td>{{$value->coin}}</td>
                      <td>{{$value->recipient}}</td>
                      <td>{{$value->sender}}</td>
                      <td>{{$value->amount}}</td>
                      <td>{{$value->Status}}</td>
                      <td>{{$value->created_at}}</td>                 
                    </tr>
                  @endforeach 
                  @foreach($user_detail['ETH_deposit_history'] as $key => $value)
                    <tr>                  
                      <td>{{ $key+1 }}</td>
                      <td>{{$value->coin}}</td>
                      <td>{{$value->recipient}}</td>
                      <td>{{$value->sender}}</td>
                      <td>{{$value->amount}}</td>
                      <td>{{$value->Status}}</td>
                      <td>{{$value->created_at}}</td>                 
                    </tr>
                  @endforeach  
                @else
                  <tr><td colspan="7">{{ 'No Record Found' }}</td></tr>
                @endif
              </tbody>
            </table>   
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="row">
    <div class="col-md-12">        
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Withdraw Details</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Coin / Currency</th>
                  <th>Recipient</th>
                  <th>Sender</th>
                  <th>Amount</th>
                  <th>Action</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($user_detail['BTC_withdraw_history'] as $key => $value)
                  <tr>                  
                    <td>{{ $key+1 }}</td>
                    <td>{{$value->coin}}</td>
                    <td>{{$value->recipient}}</td>
                    <td>{{$value->sender}}</td>
                    <td>{{$value->amount}}</td>
                    <td>{{$value->Status}}</td>
                    <td>{{$value->created_at}}</td>                 
                  </tr>
                @endforeach 
                @foreach($user_detail['ETH_withdraw_history'] as $key => $value)
                  <tr>                  
                    <td>{{ $key+1 }}</td>
                    <td>{{$value->coin}}</td>
                    <td>{{$value->recipient}}</td>
                    <td>{{$value->sender}}</td>
                    <td>{{$value->amount}}</td>
                    <td>{{$value->Status}}</td>
                    <td>{{$value->created_at}}</td>                 
                  </tr>
                @endforeach  
              </tbody>
            </table>   
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection