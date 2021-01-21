@extends('layouts.header')
@section('title', 'Commission Settings')
@section('content')
<section class="content">
  <div class="content__inner">
    <header class="content__title">
      <h1>User Details</h1>     
    </header>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <ul class="excellistf">
        <li>
        <a href="{{url('admin/users/induvidual_exportExcel').'/'.$user['id'].'/xls'}}"><span class="btn btn-success user_date"> <i class="zmdi zmdi-download zmdi-hc-fw"></i> xls</span></a>
      </li>
        <li>
        <a href="{{url('admin/users/induvidual_exportExcel').'/'.$user['id'].'/pdf'}}"><span class="btn btn-success user_date"> <i class="zmdi zmdi-download zmdi-hc-fw"></i> pdf</span></a></li>
        <li>
        <a href="{{url('admin/users/induvidual_exportExcel').'/'.$user['id'].'/csv'}}"><span class="btn btn-success user_date"> <i class="zmdi zmdi-download zmdi-hc-fw"></i> csv</span></a></li>
      </ul>
      </div>
    </div>

        <div class="row">
      <div class="col-md-12">        
        <div class="card">
          <div class="card-body">

          <h4 class="card-title">Profile Details </h4>
            <div class="table-responsive">           
              @if(count($user))
                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                        <label>Full Name :  {{ $user['first_nmae'] }} {{ $user['last_nmae'] }}</label>
                      </div>
                                    
                      <div class="form-group">
                        <label>Email :  {{ $user['email'] }} </label>
                      </div>
                   
                 </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div>
                        <img src="{{ $user['profile_img'] }}" class="profileigf">
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
    </div>

    <div class="row">
      <div class="col-md-12">        
        <div class="card">
          <div class="card-body">
          <h4 class="card-title">Wallet Details </h4>
            <div class="table-responsive">
           
              @if(count($user['commission']))

             @php $i =1 @endphp
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
                @foreach($user['commission'] as $key => $value)
                <tr>                  
                  <td>{{ $i }}</td>
                  <td>{{$value}}</td>
                  <td>{{ $user[$value.'_address'] }}</td>
                  <td>{{ $user[$value.'_deposit_balance'] }}</td>
                  <td>{{ $user[$value.'_trade_balance'] }}</td>
                  <td>{{ $user[$value.'_escrow_balance'] }}</td>
                  <td>{{ $user[$value.'_total_balance'] }}</td>
                </tr>
                @php $i++ @endphp 
                @endforeach               
                </tbody>
              @else
                <tbody>
                <tr>
                  <td>
                {{ 'No Record Found' }}
              </td>
            </tr>
              </tbody>      
              @endif
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
                  @if(count($user['buy_trade']))
                  @php $i=1; @endphp
                @foreach($user['buy_trade'] as $key => $buy_value)
                  @php 
                    $cancelled = 0.0000; 
                    $remaining = $buy_value->remaining;
                  @endphp
                     @if($buy_value->status == 2)
                        @php 
                            $cancelled = $buy_value->remaining;
                            $remaining = 0.0000 @endphp
                        @endif

                <tr>                  
                  <td>{{ $i }}</td>
                  <td>{{ $buy_value->created_at}}</td>
                  <td>{{ $buy_value->pair}}</td>
                  <td>{{ number_format($buy_value->price, 8, '.', '') }}</td>
                  <td>{{ number_format($buy_value->volume, 8, '.', '') }}</td>
                  <td>{{ $remaining}}</td>
                  <td>{{ $cancelled }}</td>
                  <td>{{ number_format($buy_value->value, 8, '.', '') }}</td>
                  <td>{{ number_format($buy_value->fees, 8, '.', '') }}</td>
                  <td>@if($buy_value->status == 0 ) 
                         Pending 
                      @elseif($buy_value->status == 2 ) 
                          Cancelled 
                      @else 
                          Completed 
                      @endif</td>
                </tr>
                @php $i++ @endphp 
                @endforeach               
                </tbody>
                @else
                <tbody>
                <tr>
                  <td>
                {{ 'No Record Found' }}
              </td>
            </tr>
              </tbody>   
            @endif
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
                  @if(count($user['sell_trade']))
                  @php $i=1; @endphp
                @foreach($user['sell_trade'] as $key => $buy_value)
                  @php 
                    $cancelled = 0.0000; 
                    $remaining = $buy_value->remaining;
                  @endphp
                     @if($buy_value->status == 2)
                        @php 
                            $cancelled = $buy_value->remaining;
                            $remaining = 0.0000 @endphp
                        @endif

                <tr>                  
                  <td>{{ $i }}</td>
                  <td>{{ $buy_value->created_at}}</td>
                  <td>{{ $buy_value->pair}}</td>
                  <td>{{ number_format($buy_value->price, 8, '.', '') }}</td>
                  <td>{{ number_format($buy_value->volume, 8, '.', '') }}</td>
                  <td>{{ $remaining}}</td>
                  <td>{{ $cancelled }}</td>
                  <td>{{ number_format($buy_value->value, 8, '.', '') }}</td>
                  <td>{{ number_format($buy_value->fees, 8, '.', '') }}</td>
                  <td>@if($buy_value->status == 0 ) 
                         Pending 
                      @elseif($buy_value->status == 2 ) 
                          Cancelled 
                      @else 
                          Completed 
                      @endif</td>
                </tr>
                @php $i++ @endphp 
                @endforeach               
                </tbody>
              @else
                <tbody>
                <tr>
                  <td>
                {{ 'No Record Found' }}
              </td>
            </tr>
              </tbody>   
              @endif
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
          <h4 class="card-title">Deposit Details </h4>
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
                  @php $i=1; @endphp
                  @if(count($user))                  
                @foreach($user['BTC_deposit_history'] as $key => $value)
                <tr>                  
                  <td>{{ $i }}</td>
                  <td>{{$value->coin}}</td>
                  <td>{{$value->recipient}}</td>
                  <td>{{$value->sender}}</td>
                  <td>{{$value->amount}}</td>
                  <td>{{$value->Status}}</td>
                  <td>{{$value->created_at}}</td>                 
                </tr>
                @php $i++ @endphp 
                @endforeach 

                @foreach($user['ETH_deposit_history'] as $key => $value)
                <tr>                  
                  <td>{{ $i }}</td>
                  <td>{{$value->coin}}</td>
                  <td>{{$value->recipient}}</td>
                  <td>{{$value->sender}}</td>
                  <td>{{$value->amount}}</td>
                  <td>{{$value->Status}}</td>
                  <td>{{$value->created_at}}</td>                 
                </tr>
                @php $i++ @endphp 
                @endforeach  

                @foreach($user['JADAX_deposit_history'] as $key => $value)
                <tr>                  
                  <td>{{ $i }}</td>
                  <td>{{$value->coin}}</td>
                  <td>{{$value->recipient}}</td>
                  <td>{{$value->sender}}</td>
                  <td>{{$value->amount}}</td>
                  <td>{{$value->Status}}</td>
                  <td>{{$value->created_at}}</td>                 
                </tr>
                @php $i++ @endphp 
                @endforeach 

                </tbody>                           
              @else
              <tbody>
                <tr>
                  <td>
                {{ 'No Record Found' }}
              </td>
            </tr>
              </tbody>
              @endif
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
          <h4 class="card-title">Withdraw Details </h4>
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
                  @php $i=1; @endphp
                  @if(count($user))                  
                @foreach($user['BTC_withdraw_history'] as $key => $value)
                <tr>                  
                  <td>{{ $i }}</td>
                  <td>{{$value->coin}}</td>
                  <td>{{$value->recipient}}</td>
                  <td>{{$value->sender}}</td>
                  <td>{{$value->amount}}</td>
                  <td>{{$value->Status}}</td>
                  <td>{{$value->created_at}}</td>                 
                </tr>
                @php $i++ @endphp 
                @endforeach 

                @foreach($user['ETH_withdraw_history'] as $key => $value)
                <tr>                  
                  <td>{{ $i }}</td>
                  <td>{{$value->coin}}</td>
                  <td>{{$value->recipient}}</td>
                  <td>{{$value->sender}}</td>
                  <td>{{$value->amount}}</td>
                  <td>{{$value->Status}}</td>
                  <td>{{$value->created_at}}</td>                 
                </tr>
                @php $i++ @endphp 
                @endforeach  

                @foreach($user['JADAX_withdraw_history'] as $key => $value)
                <tr>                  
                  <td>{{ $i }}</td>
                  <td>{{$value->coin}}</td>
                  <td>{{$value->recipient}}</td>
                  <td>{{$value->sender}}</td>
                  <td>{{$value->amount}}</td>
                  <td>{{$value->Status}}</td>
                  <td>{{$value->created_at}}</td>                 
                </tr>
                @php $i++ @endphp 
                @endforeach 

                </tbody>                           
              @else
              <tbody>
                <tr>
                  <td>
                {{ 'No Record Found' }}
              </td>
            </tr>
              </tbody>
              @endif
              </table>   
            </div>
          </div>
        </div>
      </div>
    </div>


  </section>
@endsection