<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyTrades extends Model
{
	protected $table = 'buytrades';
	
    public static function buyTradesHistory()
    {
    	$history = BuyTrades::on('mysql2')->where([['order_type', '=', 1],['pair', '=', 1]])->orderBy('id', 'desc')->paginate(10);

    	return $history;
    }

    public static function buyTradesHistorySearch($request)
    { 
        if($request->status != 'All')
        {
            if(isset($request->email))
            { 
                $history = BuyTrades::on('mysql2')->where('order_type', $request->type2)->where('pair', $request->tradepair)->where('status', $request->status)->where('uid', useremail($request->email)->id)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id', 'desc')->paginate(10);

                $total = BuyTrades::on('mysql2')->where('pair', $request->tradepair)->where('status', $request->status)->where('uid', useremail($request->email)->id)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id', 'desc')->get();

            }
            else
            {
                $history = BuyTrades::on('mysql2')->where('order_type', $request->type2)->where('pair', $request->tradepair)->where('status', $request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id', 'desc')->paginate(10);

                $total = BuyTrades::on('mysql2')->where('pair', $request->tradepair)->where('status', $request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id', 'desc')->get();
            }
            
        }
        else
        {
            if(isset($request->email))
            {
                $history = BuyTrades::on('mysql2')->where('order_type', $request->type2)->where('pair', $request->tradepair)->where('uid', useremail($request->email)->id)->whereBetween('created_at',[$request->from,$request->to])->orderBy('price', 'desc')->paginate(10);

                $total = BuyTrades::on('mysql2')->where('pair', $request->tradepair)->where('uid', useremail($request->email)->id)->whereBetween('created_at',[$request->from,$request->to])->orderBy('price', 'desc')->get();
            }
            else
            {
                $history = BuyTrades::on('mysql2')->where('order_type', $request->type2)->where('pair', $request->tradepair)->whereBetween('created_at',[$request->from,$request->to])->orderBy('price', 'desc')->paginate(10);

                $total = BuyTrades::on('mysql2')->where('pair', $request->tradepair)->whereBetween('created_at',[$request->from,$request->to])->orderBy('price', 'desc')->get();
            }
        }
    	 
    	return array(
            'history'=>$history,
            'total'=>$total
        );
    }
}
