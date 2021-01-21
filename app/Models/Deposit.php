<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;


class Deposit extends Model
{
    protected $table = "deposits";

    public static function history($request)
    { 
        if($request->status == 'All')
        {
            $history= Deposit::on('mysql2')->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }
        else
        {   
            $history= Deposit::on('mysql2')->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }  
        return $history;
    }



    public static function deposit_history($request)
    { 
        $uid = $request->uid;
        if($request->status == 'All')
        {
            $history= Deposit::on('mysql2')->where('uid',$uid)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }
        else
        {   
            $history= Deposit::on('mysql2')->where('uid',$uid)->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }  
        return $history;
    }

    public static function depositUpdate($request)
    {
        $deposit = Deposit::on('mysql2')->where('id',$request->id)->first();

        if(is_object($deposit))
        {
            $deposit->status = $request->status;
            $deposit->save();   

            if($request->status == 2){

                $balanceUpdate = UserWallet::on('mysql2')->where('user_id',$deposit->uid)->where('currency','USD')->first();
                $balanceUpdate->balance = $balanceUpdate->balance + $deposit->credit_amount;
                $balanceUpdate->save(); 
            }

            return true;            
        }else{
            return false;
        }

        return 'Status updated successfully';
    }



    public static function listView($uid,$coin)
    {
    	$list = Deposit::on('mysql2')->where([ 'currency' => $coin])->orderBy('id', 'desc')->paginate(15);     	
    	return $list;
    }
    public static function orderCancel($id,$uid)
    {
    	$deposit = Deposit::on('mysql2')->where(['uid' => $uid,'status'=> 0])->first();
    	if(is_object($deposit))
        {
        	$deposit->status = 3;
        	$deposit->save();   
        	return true;         
        }else{
            return false;
        }
    }

    public static function totalTransactions($type)
    {
        $total = Deposit::on('mysql2')->count();

        return $total;
    }

    public static function today()
    {
        $today = Deposit::on('mysql2')->whereDate('created_at',Carbon::today())->count();

        return $today;
    }

}
