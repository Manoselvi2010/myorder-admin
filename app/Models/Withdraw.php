<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Withdraw extends Model
{
    protected $table = 'withdraw';


    public static function history($request)
    {
         if($request->status == 'All')
        {
            $history= Withdraw::on('mysql2')->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }
        else
        {   
            $history= Withdraw::on('mysql2')->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }  
        
        return $history;
    }


    public static function withdraw_history($request)
    { 

         $uid = $request->uid;
        if($request->status == 'All')
        {
            $history= Withdraw::on('mysql2')->where('uid',$uid)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }
        else
        {   
            $history= Withdraw::on('mysql2')->where('uid',$uid)->where('status',$request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id','desc')->paginate(10);
        }  
        return $history;
    }

    public static function withdrawUpdate($request)
    {
        $withdraw = Withdraw::on('mysql2')->where('id',$request->id)->first();

        if($request->status == 3)
        { 

            $balanceUpdate = UserWallet::on('mysql2')->where('user_id',$withdraw->uid)->where('currency','USD')->first();
            $balanceUpdate->balance = $balanceUpdate->balance + $withdraw->amount;
            $balanceUpdate->save(); 

            $withdraw->status = 3 ;
            $withdraw->save();

            $admin = AdminWallet::on('mysql2')->where('currency','USD')->first();
            $admin->withdraw = $admin->withdraw - $withdraw->admin_fee;
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
        $total = Withdraw::on('mysql2')->count();

        return $total;
    }

    public static function today()
    {
        $today = Withdraw::on('mysql2')->whereDate('created_at',Carbon::today())->count();

        return $today;
    }

}
