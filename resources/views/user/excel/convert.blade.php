<section class="content">
  <div class="content__inner">
    <div class="row">
      <div class="col-md-12">        
        <div class="card">
          <div class="card-body">
            <h4 class="card-title" style="background-color: #1a417d;color: #fff">Profile Details </h4>
            <div class="table-responsive"> 
              @if(count($user))
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Full Name</td>
                      <td> {{ $user['first_nmae']}} {{ $user['last_nmae'] }}</td>
                    </tr>
                    <tr>
                      <td>Email</td>                     
                      <td>  {{ $user['email'] }} </td>
                    </tr>
                  </tbody>
                </table>
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
            <h4 class="card-title" style="background-color: #1a417d;color: #fff">Wallet Details </h4>
            <div class="table-responsive">           
              <table class="table table-bordered">
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
                  @if(count($user['commission']))
                    @foreach($user['commission'] as $key => $value)
                      <tr>                  
                      <td>{{ $key+1 }}</td>
                      <td>{{$value}}</td>
                      @if(isset($user[$value.'_address']))
                        <td>{{ $user[$value.'_address'] }}</td>
                      @else
                        <td>-</td>
                      @endif
                      @if(isset($user[$value.'_deposit_balance']))
                        <td>{{ $user[$value.'_deposit_balance'] }}</td>
                      @else
                        <td>-</td>
                      @endif
                      @if(isset($user[$value.'_trade_balance']))
                        <td>{{ $user[$value.'_trade_balance'] }}</td>
                      @else
                        <td>-</td>
                      @endif
                      @if(isset($user[$value.'_escrow_balance']))
                        <td>{{ $user[$value.'_escrow_balance'] }}</td>
                      @else
                        <td>-</td>
                      @endif
                      @if(isset($user[$value.'_total_balance']))
                        <td>{{ $user[$value.'_total_balance'] }}</td>
                      @else
                        <td>-</td>
                      @endif
                    </tr>
                    @endforeach               
                  @else
                    <tr><td>{{ 'Record Not Found' }}</td></tr>
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
            <h4 class="card-title" style="background-color: #1a417d;color: #fff">Buy Trade Details </h4>
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
                    @foreach($user['buy_trade'] as $key => $buy_value)
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
                    <tr><td>{{ 'Record Not Found' }}</td></tr>
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
            <h4 class="card-title" style="background-color: #1a417d;color: #fff">Sell Trade Details </h4>
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
                    @foreach($user['sell_trade'] as $key => $buy_value)
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
                    <tr><td>{{ 'Record Not Found' }}</td></tr>
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
            <h4 class="card-title" style="background-color: #1a417d;color: #fff">Deposit Details </h4>
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
                  @if(count($user['BTC_deposit_history']) || count($user['ETH_deposit_history']) ) 
                    @foreach($user['BTC_deposit_history'] as $key => $value)
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
                    @foreach($user['ETH_deposit_history'] as $key => $value)
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
                    <tr><td>{{ 'Record Not Found' }}</td></tr>
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
            <h4 class="card-title" style="background-color: #1a417d;color: #fff">Withdraw Details </h4>
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
                  @if(count($user['BTC_withdraw_history'])||count($user['ETH_withdraw_history']))      
                    @foreach($user['BTC_withdraw_history'] as $key => $value)
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
                    @foreach($user['ETH_withdraw_history'] as $key => $value)
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
                    <tr><td> {{ 'Record Not Found' }}</td></tr>
                  @endif
                </tbody>
              </table>   
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>