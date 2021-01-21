<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepositEmail; 

class CurrencyDeposit extends Model
{
	protected $table = 'deposits';

    public static function depsoitList($currency)
    {
    	$currency_trasnaction = CurrencyDeposit::on('mysql2')->where('currency', $currency)->orderBy('id', 'desc')->where([['currency', '=', $currency]])->paginate(10);

    	return $currency_trasnaction;
    }

    public static function edit($id)
    {
    	$currency_trasnaction = CurrencyDeposit::on('mysql2')->where('id', $id)->first();

    	return $currency_trasnaction;
    }

    public static function statusUpdate($request)
    {
    	$id = $request->id;
        $amount = $request->amount;
        $status = $request->status;
        $credit_amount = $request->credit_amount;
        
        $deposit_data = CurrencyDeposit::on('mysql2')->where('id', $id)->first();

        if($deposit_data)
        { 
            if($status == 1)
            { 
                $updateBal = UserWallet::on('mysql2')->where('uid',$deposit_data->uid)->where('currency',$deposit_data->currency)->first();

                if(isset($updateBal->balance))
                {   
                	$updateBal->balance = $updateBal->balance + $request->amount; 
                	$updateBal->site_balance = $updateBal->site_balance + $request->amount; 
                	$updateBal->save();

                }
                else
                {
                	$balance = new UserWallet;
                	$balance->setConnection('mysql2');
                	$balance->currency = $deposit_data->currency;
                	$balance->balance = number_format($request->amount,2);
                	$balance->escrow_balance = 0;
                	$balance->main_balance = 0;
                	$balance->site_balance = number_format($request->amount,2);
                	$balance->save();

                }

                $status1 = 'Accept'; 
                
            }
            else
            {
                 $status1 = 'Cancel'; 
            }

            $deposit_data->status = $status;
            $deposit_data->save();

        }

        $user = User::on('mysql2')->where('id',$deposit_data->uid)->first(); 
       
        $details = array(
                'status'=>$status1,
                'coin'=>'BTC',
                'amount'=>$request->amount,
                'user' => $user->name 
                ); 
        
        Mail::to($user->email)->send(new DepositEmail($details));

        return true;
    }

    
}
