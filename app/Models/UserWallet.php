<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'user_wallets';
	protected $fillable = ['balance','currency','user_id','mukavari'];
    
    public static function walletUpdate($request)
    {
    	$wallet = UserWallet::on('mysql2')->where('currency',$request->coin)->where('user_id',$request->uid)->first(); 

    	if(is_object($wallet)){
    		$wallet->balance = $request->amount;
    		$wallet->save();	
    	}else{
    		UserWallet::on('mysql2')->create([
    			'user_id'      => $request->uid,
    			'currency' => $request->coin,
    			'balance'  => $request->amount
    		]);
    	}
    	
    }
}
