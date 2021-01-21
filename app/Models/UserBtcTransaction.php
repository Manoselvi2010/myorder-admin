<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserWallet;
use App\Models\BtcAdminAddress;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepositEmail;
use App\Mail\WithdrawEmail;
use Carbon\Carbon;
use App\Models\Adminwallet;
use Auth;

class UserBtcTransaction extends Model
{ 
    
	public static function history($request)
    {
    	 if($request->status == 0)
        {
            $history= UserBtcTransaction::on('mysql2')->where('type',$request->type)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }
        else
        {   
            $history= UserBtcTransaction::on('mysql2')->where('type',$request->type)->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }  
        
        return $history;
    }

    public static function withdrawEdit($id)
    {
    	$withdraw = UserBtcTransaction::on('mysql2')->where('id',$id)->first();

    	return $withdraw;
    } 

    public static function withdrawUpdate($request)
    {
    	$withdraw = UserBtcTransaction::on('mysql2')->where('id',$request->id)->first();

        if($request->status == 3)
        { 

            $balanceUpdate = UserWallet::on('mysql2')->where('user_id',$withdraw->user_id)->where('currency','BTC')->first();
            $balanceUpdate->balance = $balanceUpdate->balance + $withdraw->total_amount;
            $balanceUpdate->save(); 

            $withdraw->status = 3 ;
            $withdraw->save();

            $admin = AdminWallet::on('mysql2')->where('currency','BTC')->first();
            $admin->withdraw = $admin->withdraw - $withdraw->fees;
            $admin->save();

            $status = 'Cancel';

        }
        elseif($request->status == 2)
        {
            $withdraw->status = 2;
            $withdraw->save();
            
            $status = 'Accept'; 
        } 

        

        return 'Withdrawn status updated successfully';
    }

    public static function totalTransactions($type)
    {
        $total = UserBtcTransaction::on('mysql2')->where('type',$type)->count();

        return $total;
    }

    public static function today()
    {
        $today = UserBtcTransaction::on('mysql2')->whereDate('created_at',Carbon::today())->count();

        return $today;
    }

    public static function deposit_history($request)
    { 
        $uid = $request->uid;
        if($request->status == 'All')
        {
            $history= UserBtcTransaction::on('mysql2')->where('user_id',$uid)->where('type',$request->type)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }
        else
        {   
            $history= UserBtcTransaction::on('mysql2')->where('user_id',$uid)->where('type',$request->type)->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }  
        return $history;
    }
    
}
