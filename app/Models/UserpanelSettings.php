<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserpanelSettings extends Model
{
	public static function index()
	{
		$list = UserpanelSettings::on('mysql2')->first();
		
		return $list;
	}

	public static function saveUserpanel($request)
	{
		$settings = UserpanelSettings::on('mysql2')->first();
		$settings->email_verification = $request->email_verification;
		$settings->mobile_verification = $request->mobile_verification;
		$settings->twofa = $request->twofa;
		$settings->kyc = $request->kyc;
		$settings->withdraw_limit = $request->withdraw_limit;
		$settings->deposit_limit = $request->deposit_limit;
		$settings->site_balance = $request->site_balance;
		$settings->notification = $request->notification;
		if($settings->notification == 1)
		{
			$settings->notification_medium = $request->notification_medium;
		}
		$settings->save();

		return true;
	}	
}