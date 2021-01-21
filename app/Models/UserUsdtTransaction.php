<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class UserUsdtTransaction extends Model
{
    public static function deposit_history($request)
	{ 

		 $uid = $request->uid;

		if($request->status == 'All')
		{
			$history= UserUsdtTransaction::on('mysql2')->where('user_id',$uid)->where('type',$request->type)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
		}
		else
		{	
			$history= UserUsdtTransaction::on('mysql2')->where('user_id',$uid)->where('type',$request->type)->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
		}  
        return $history;
	}

	public static function history($request)
    {
    	 if($request->status == 0)
        {
            $history= UserUsdtTransaction::on('mysql2')->where('type',$request->type)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }
        else
        {   
            $history= UserUsdtTransaction::on('mysql2')->where('type',$request->type)->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }  
        
        return $history;
    }

	public static function withdrawSave($request,$totalAmount,$adminFee,$from)
	{
		$withdraw = new UserUsdtTransaction;
		$withdraw->user_id = \Auth::id();
		$withdraw->type = 'send';
		$withdraw->recipient = $request->toaddress;
		$withdraw->sender = $from;
		$withdraw->amount = $request->amount;
		$withdraw->fees = $adminFee;
		$withdraw->total_amount = $totalAmount;
		$withdraw->status = 1;
		$withdraw->save();

		return true;
	}

	public static function withdrawUpdate($request)
    {
        $withdraw = UserUsdtTransaction::on('mysql2')->where('id',$request->id)->first();

        if($request->status == 3)
        { 
            $balanceUpdate = UserWallet::on('mysql2')->where('user_id',$withdraw->user_id)->where('currency','USDT')->first(); 
            $balanceUpdate->balance = $balanceUpdate->balance + $withdraw->total_amount;
            $balanceUpdate->save(); 

            $withdraw->status = 3 ;
            $withdraw->save();

            $admin = AdminWallet::on('mysql2')->where('currency','USDT')->first();
            $admin->withdraw = $admin->withdraw - $withdraw->fees;
            $admin->save();

            $status = 'Cancel';

        }
        elseif($request->status == 2)
        {
            $withdraw->txid = $request->transactinid;
            $withdraw->status = 2;
            $withdraw->save();
            
            $status = 'Accept'; 
        } 

        return 'Withdrawn status updated successfully';
    }

    public static function totalTransactions($type)
    {
        $total = UserUsdtTransaction::on('mysql2')->where('type',$type)->count();

        return $total;
    }

    public static function today()
    {
        $today = UserUsdtTransaction::on('mysql2')->whereDate('created_at',Carbon::today())->count();

        return $today;
    }


}
