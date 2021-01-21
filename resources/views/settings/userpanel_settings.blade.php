@extends('layouts.header')
@section('title', 'Support Ticket')
@section('content')
<section class="content">
<div class="content__inner">
  <header class="content__title">
    <h1>User Panel SETTING</h1>
  </header>
  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>{{ $message }}</strong>
    </div>
  @endif 
  <div class="card">
    <div class="card-body">
      <form method="post" action="{{ url('admin/save_userpanel_settings') }}" autocomplete="off">
      {{ csrf_field() }}
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Email Verfication</label>
            </div>
          </div>
          <div class="col-md-4">
            <div id="radioBtn" class="btn-group">
              @if($settings->email_verification == 0)
                <a class="btn btn-primary btn-sm notActive" data-toggle="email_verification" data-title="1">YES</a>
                <a class="btn btn-primary btn-sm active" data-toggle="email_verification" data-title="0">NO</a>
              @else
                <a class="btn btn-primary btn-sm active" data-toggle="email_verification" data-title="1">YES</a>
                <a class="btn btn-primary btn-sm notActive" data-toggle="email_verification" data-title="0">NO</a>
              @endif
            </div>
            <input type="hidden" name="email_verification" id="email_verification" value="{{$settings->email_verification}}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Mobile OTP Verfication</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div id="radioBtn" class="btn-group">
                @if($settings->mobile_verification == 0)
                  <a class="btn btn-primary btn-sm notActive" data-toggle="mobile_verification" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm active" data-toggle="mobile_verification" data-title="0">NO</a>
                @else
                  <a class="btn btn-primary btn-sm active" data-toggle="mobile_verification" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="mobile_verification" data-title="0">NO</a>
                @endif
              </div>
              <input type="hidden" name="mobile_verification" id="mobile_verification" value="{{$settings->mobile_verification}}">
              <i class="form-group__bar"></i> </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>2FA Authentication</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div id="radioBtn" class="btn-group">
                @if($settings->twofa == 0)
                  <a class="btn btn-primary btn-sm notActive" data-toggle="twofa" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm active" data-toggle="twofa" data-title="0">NO</a>
                @else
                  <a class="btn btn-primary btn-sm active" data-toggle="twofa" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="twofa" data-title="0">NO</a>
                @endif
              </div>
              <input type="hidden" name="twofa" id="twofa" value="{{$settings->twofa}}">
              <i class="form-group__bar"></i> </div>
          </div>
        </div>

        @if($settings->twofa == 0)
          <div id="2fa_medium_div" style="display:block">
        @else
          <div id="2fa_medium_div" style="display:none">
        @endif

   <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>2FA Authentication Type</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div id="checknoxBtn" class="btn-group">
                @if(count($two_options)>0)
                @php $i=1 @endphp
                @foreach($two_options as $op)
                  <a id="2fa_medium{{$i}}" class="btn btn-primary btn-sm {{($op->status == 1)?'active':'notActive'}}" data-toggle="2fa_medium" data-title="{{$i}}">{{ $op->name }}</a>
                    
                  @php $i++ @endphp
              @endforeach
                @endif
              </div>
              <input type="hidden" name="2fa_medium" id="2fa_medium" value="{{$settings->notification_medium}}">
              <i class="form-group__bar"></i> </div>
          </div>
        </div>
      </div>

        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>KYC</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div id="radioBtn" class="btn-group">
                @if($settings->kyc == 0)
                  <a class="btn btn-primary btn-sm notActive" data-toggle="kyc" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm active" data-toggle="kyc" data-title="0">NO</a>
                @else
                  <a class="btn btn-primary btn-sm active" data-toggle="kyc" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="kyc" data-title="0">NO</a>
                @endif
              </div>
              <input type="hidden" name="kyc" id="kyc" value="{{$settings->kyc}}">
              <i class="form-group__bar"></i> </div>
          </div>
        </div>
      
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Withdraw Limit</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div id="radioBtn" class="btn-group">
                @if($settings->withdraw_limit == 0)
                  <a class="btn btn-primary btn-sm notActive" data-toggle="withdraw_limit" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm active" data-toggle="withdraw_limit" data-title="0">NO</a>
                @else
                  <a class="btn btn-primary btn-sm active" data-toggle="withdraw_limit" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="withdraw_limit" data-title="0">NO</a>
                @endif
              </div>
              <input type="hidden" name="withdraw_limit" id="withdraw_limit" value="{{$settings->withdraw_limit}}">
              <i class="form-group__bar"></i> </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Deposit Limit</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div id="radioBtn" class="btn-group">
                @if($settings->deposit_limit == 0)
                  <a class="btn btn-primary btn-sm notActive" data-toggle="deposit_limit" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm active" data-toggle="deposit_limit" data-title="0">NO</a>
                @else
                  <a class="btn btn-primary btn-sm active" data-toggle="deposit_limit" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="deposit_limit" data-title="0">NO</a>
                @endif
              </div>
              <input type="hidden" name="deposit_limit" id="deposit_limit" value="{{$settings->deposit_limit}}">
              <i class="form-group__bar"></i> </div>
          </div>
        </div> 
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Site Balance</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div id="radioBtn" class="btn-group">
                @if($settings->site_balance == 0)
                  <a class="btn btn-primary btn-sm notActive" data-toggle="site_balance" data-title="1">Real</a>
                  <a class="btn btn-primary btn-sm active" data-toggle="site_balance" data-title="0">Virtual</a>
                @else
                  <a class="btn btn-primary btn-sm active" data-toggle="site_balance" data-title="1">Real</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="site_balance" data-title="0">Virtual</a>
                @endif
              </div>
              <input type="hidden" name="site_balance" id="site_balance" value="{{$settings->deposit_limit}}">
              <i class="form-group__bar"></i> </div>
          </div>
        </div> 
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Notification</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div id="radioBtn" class="btn-group">
                @if($settings->notification == 0)
                  <a class="btn btn-primary btn-sm notActive" data-toggle="notification" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm active" data-toggle="notification" data-title="0">NO</a>
                @else
                  <a class="btn btn-primary btn-sm active" data-toggle="notification" data-title="1">YES</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="notification" data-title="0">NO</a>
                @endif
              </div>
              <input type="hidden" name="notification" id="notification" value="{{$settings->notification}}">
              <i class="form-group__bar"></i> </div>
          </div>
        </div>
        @if($settings->notification == 1)
          <div id="notification_medium_div" style="display:block">
        @else
          <div id="notification_medium_div" style="display:none">
        @endif
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Notification Type</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div id="radioBtn" class="btn-group">
                @if($settings->notification_medium == 1)
                  <a class="btn btn-primary btn-sm active" data-toggle="notification_medium" data-title="1">Email</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="notification_medium" data-title="2">Mobile</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="notification_medium" data-title="3">Both</a>
                @elseif($settings->notification_medium == 2)
                  <a class="btn btn-primary btn-sm notActive" data-toggle="notification_medium" data-title="1">Email</a>
                  <a class="btn btn-primary btn-sm active" data-toggle="notification_medium" data-title="2">Mobile</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="notification_medium" data-title="3">Both</a>
                @else
                  <a class="btn btn-primary btn-sm notActive" data-toggle="notification_medium" data-title="1">Email</a>
                  <a class="btn btn-primary btn-sm notActive" data-toggle="notification_medium" data-title="2">Mobile</a>
                  <a class="btn btn-primary btn-sm active" data-toggle="notification_medium" data-title="3">Both</a>
                @endif
              </div>
              <input type="hidden" name="notification_medium" id="notification_medium" value="{{$settings->notification_medium}}">
              <i class="form-group__bar"></i> </div>
          </div>
        </div>
      </div>
        <div class="form-group">
          <button type="submit"  class="btn btn-light"><i class=""></i> Save</button>
        </div>
      </form>
      <hr/>
    </div>
  </div>
</div>
</section>


<script>
  $('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
    checking();
})

    $('#checknoxBtn a').on('click', function(){

    var click = $(this).data('title');
    


$('#2fa_medium1').change(function() {
    // this will contain a reference to the checkbox   
    if (this.checked) {
        // the checkbox is now checked 
    } else {
        // the checkbox is now no longer checked
    }
});


/*    alert(sel);
    alert(tog);
    $('#'+tog).prop('value', sel);
    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');*/
})


</script>
<script type="text/javascript">
  function checking()
  {
    if($('#notification').val()==0)
    {
      document.getElementById('notification_medium_div').style.display = 'none'; 
    } 
    else
    {
      document.getElementById('notification_medium_div').style.display = 'block'; 
    }

    if($('#twofa').val()==0)
    {
      document.getElementById('2fa_medium_div').style.display = 'none'; 
    } 
    else
    {
      document.getElementById('2fa_medium_div').style.display = 'block'; 
    }


  }

 

</script>

@endsection

