<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail; 
use App\Mail\WithdrawEmail; 

class CurrencyWithdraw extends Model
{
	protected $table = 'withdraw';

    public static function histroy($type)
    {
    	$histroy = CurrencyWithdraw::on('mysql2')->where('currency' , $type)->orderBy('id', 'desc')->paginate(15);

    	return $histroy;
    }

    public static function edit($id)
    {
    	$histroy = CurrencyWithdraw::on('mysql2')->where('id', $id)->first();

    	return $histroy;
    }

    public static function withdrawUpdate($request)
    {
        $id = $request->id;
        $status = $request->status;
        $currency = $request->currency;
        
        $deposit_data = CurrencyWithdraw::on('mysql2')->where('id', $request->id)->first();

        if($deposit_data)
        {
            $amount = $deposit_data->amount+$deposit_data->adminfee;
            $uid = $deposit_data->uid;

            if($status == 2)
            {
                $user = UserWallet::on('mysql2')->where('uid',$deposit_data->uid)->where('currency',$deposit_data->currency)->first(); 
                $user->balance = $user->balance + $amount;
                $user->site_balance = $user->site_balance + $amount;
                $user->save();

                $status1 = 'Cancel'; 
            } else {

                $status1 = 'Accept'; 
            }

            $deposit_data->status = $status;
            $deposit_data->save();
            
        }

        $user = User::on('mysql2')->where('id',$deposit_data->uid)->first(); 
       
        $details = array(
                'status'=>$status1,
                'coin'=> currency($deposit_data->type),
                'amount'=>$deposit_data->amount,
                'user' => $user->name 
                ); 
        
        Mail::to($user->email)->send(new WithdrawEmail($details));

        return true;
    }
}
