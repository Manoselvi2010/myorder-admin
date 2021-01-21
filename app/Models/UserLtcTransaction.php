<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\UserBtcAddress;
use Auth;
use Carbon\Carbon;

class UserLtcTransaction extends Model
{

    public function ltcUserTransaction()
	{
	  return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public static function deposit_history($request)
	{ 
        $uid = $request->uid;
		if($request->status == 'All')
		{
			$history= UserLtcTransaction::on('mysql2')->where('user_id',$uid)->where('type',$request->type)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
		}
		else
		{	
			$history= UserLtcTransaction::on('mysql2')->where('user_id',$uid)->where('type',$request->type)->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
		}  
        return $history;
	}

	public static function history($request)
    {
    	 if($request->status == 0)
        {
            $history= UserLtcTransaction::on('mysql2')->where('type',$request->type)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }
        else
        {   
            $history= UserLtcTransaction::on('mysql2')->where('type',$request->type)->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }  
        
        return $history;
    }

    public static function withdrawEdit($id)
    {
    	$withdraw = UserLtcTransaction::on('mysql2')->where('id',$id)->first();

    	return $withdraw;
    } 

    public static function withdrawUpdate($request)
    {
    	$withdraw = UserLtcTransaction::on('mysql2')->where('id',$request->id)->first();

        if($request->status == 3)
        { 

            $balanceUpdate = UserWallet::on('mysql2')->where('user_id',$withdraw->user_id)->where('currency','LTC')->first();
            $balanceUpdate->balance = $balanceUpdate->balance + $withdraw->total_amount;
            $balanceUpdate->save(); 

            $withdraw->status = 3 ;
            $withdraw->save();

            $admin = AdminWallet::on('mysql2')->where('currency','LTC')->first();
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
        $total = UserLtcTransaction::on('mysql2')->where('type',$type)->count();

        return $total;
    }

    public static function today()
    {
        $today = UserLtcTransaction::on('mysql2')->whereDate('created_at',Carbon::today())->count();

        return $today;
    }
    

	public static function withdrawSave($request,$totalAmount,$adminFee,$from)
	{
		$withdraw = new UserLtcTransaction;
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
}
