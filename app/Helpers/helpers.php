<?php

function user($id)
{
	$user = App\Models\User::where('id',$id)->first();

	return $user;
}
function username($id)
{
	$user = App\Models\User::where('id',$id)->first();

	return $user->fname;
}

function useremail($email)
{
	$user = App\Models\User::where('email',$email)->first();

	return $user;
}
function country()
{
	
	$countries = App\Models\Countries::on('mysql2')->get();

	return $countries;
}

function country_name($id)
{
	$countries = App\Models\Countries::on('mysql2')->where('id',$id)->first();

	return $countries;
}

function currency($type)
{
	if($type == 4)
	{
		$currency = 'USD';
	}else if($type == 5){
		$currency = 'TRY';	
	}else {
		$currency = 'EUR';
	}
	return $currency;
}

function bank($id)
{
	$bank = App\Models\Bank::on('mysql2')->where('id',$id)->first(); 
	
	return $bank;
}

function Kyc($id)
{
	$kyc = App\Models\Kyc::on('mysql2')->where('user_id',$id)->first(); 
	
	return $kyc;
}

function humanTiming ($time)
{
	$time = time() - $time;
	$time = ($time < 1)? 1 : $time;
	$tokens = array (
		31536000 => 'year',
		2592000 => 'month',
		604800 => 'week',
		86400 => 'day',
		3600 => 'hour',
		60 => 'min',
		1 => 'sec'
	);
	foreach ($tokens as $unit => $text) {
		if ($time < $unit) continue;
		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits.' '.$text.(($numberOfUnits > 1) ? 's' : '');
	}
}

function  userBalance($id,$type)
{
	$wallet = App\Models\UserWallet::on('mysql2')->where('user_id',$id)->where('currency',$type)->first();
	if(isset($wallet->balance))
	{
		return number_format($wallet->balance,8,'.','');
	}
	else
	{
		return number_format(0,8,'.','');
	}
	
}

function adminCommissionIncome($type)
{
	$commission = App\Models\Adminwallet::on('mysql2')->where('currency',$type)->first();

	if(isset($commission->commission))
	{
		$commission = $commission->commission;
	}
	else
	{
		$commission = 0; 
	}

	return $commission;

}

function adminWithdrawIncome($type)
{
	$withdraw = App\Models\Adminwallet::on('mysql2')->where('currency',$type)->first();

	if(isset($withdraw->withdraw))
	{
		$withdraw = $withdraw->withdraw;
	}
	else
	{
		$withdraw = 0; 
	}

	return $withdraw;

}


function getadmin($id)
{
	$user = App\Models\Admin::where('id',$id)->first();

	return $user;
}
function adminemail($id)
{
	$user = App\Models\Admin::where('id',$id)->first();

	return $user->email;
}

function adminrole($id)
{
	$user = App\Models\Admin::where('id',$id)->first();

	return explode(',',$user->role);
}

