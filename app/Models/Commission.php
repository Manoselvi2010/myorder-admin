<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{

    protected $connection = 'mysql2';

    public static function index()
    {
    	$commission = Commission::on('mysql2')->paginate(10);
    	return $commission;
    }
    public static function save_commission($request)
    {
        $data = $request->all();
        $commission = new Commission();
        $commission->source      = $data['source'];
        $commission->coinname    = $data['currency'];
        $commission->buy_trade   = floatval($data['trade']); 
        $commission->sell_trade  = floatval($data['sell']);
        $commission->withdraw    = floatval($data['withdraw']);
        $commission->type        = 'token';
        $commission->net_fee     = $data['netfee'];
        $commission->description = $data['description'];
        $commission->save(); 
        return true;
    }
    public static function edit($id)
    {
    	$commission = Commission::on('mysql2')->where('id', $id)->first();
    	return $commission;
    }
    public static function commissionUpdate($request)
    {
    	$commission = Commission::on('mysql2')->where('id', $request->id)->where('source',$request->currency)->first();
        $commission->id = $request->id; 
        $commission->withdraw = floatval($request->withdraw);
        $commission->buy_trade = floatval($request->trade); 
        $commission->sell_trade = floatval($request->sell);
        $commission->net_fee = $request->netfee;
        $commission->description = $request->description;
        $commission->save();        
        return true;   
    }
}
