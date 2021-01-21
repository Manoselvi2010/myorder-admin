<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellTrades extends Model
{
	protected $table = 'selltrades';
	
	 public static function sellTradeuser() 
    {
        return $this->belongsTo('App\User', 'uid', 'id');
    }

    public static function sellTradesHistory($request)
    {
    	if($request->status != 'All')
        {
            if(isset($request->email))
            { 
                $history = SellTrades::on('mysql2')->where('order_type', $request->type2)->where('pair', $request->tradepair)->where('status', $request->status)->where('uid', useremail($request->email)->id)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id', 'desc')->paginate(10);

                $total = SellTrades::on('mysql2')->where('pair', $request->tradepair)->where('status', $request->status)->where('uid', useremail($request->email)->id)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id', 'desc')->get();
            }
            else
            {
                $history = SellTrades::on('mysql2')->where('order_type', $request->type2)->where('pair', $request->tradepair)->where('status', $request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id', 'desc')->paginate(10);

                $total = SellTrades::on('mysql2')->where('pair', $request->tradepair)->where('status', $request->status)->whereBetween('created_at',[$request->from,$request->to])->orderBy('id', 'desc')->get();
            }
            
        }
        else
        {
            if(isset($request->email))
            {
                $history = SellTrades::on('mysql2')->where('order_type', $request->type2)->where('pair', $request->tradepair)->where('uid', useremail($request->email)->id)->whereBetween('created_at',[$request->from,$request->to])->orderBy('price', 'desc')->paginate(10);

                $total = SellTrades::on('mysql2')->where('pair', $request->tradepair)->where('uid', useremail($request->email)->id)->whereBetween('created_at',[$request->from,$request->to])->orderBy('price', 'desc')->get();

            }
            else
            {
                $history = SellTrades::on('mysql2')->where('order_type', $request->type2)->where('pair', $request->tradepair)->whereBetween('created_at',[$request->from,$request->to])->orderBy('price', 'desc')->paginate(10);

                $total = SellTrades::on('mysql2')->where('pair', $request->tradepair)->whereBetween('created_at',[$request->from,$request->to])->orderBy('price', 'desc')->get();

            }
        }

    	return array(
            'history'=>$history,
            'total'=>$total
        );
    }
}
