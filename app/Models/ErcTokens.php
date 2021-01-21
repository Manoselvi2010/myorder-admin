<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErcTokens extends Model
{
	public static function list()
	{
		$list = ErcTokens::on('mysql2')->get();

		return $list;
	} 

	public static function add($request)
	{
		$save = new ErcTokens();
		$save->setConnection('mysql2');
		$save->name = $request->name;
		$save->contract_address = $request->contract_address;
		$save->abi_array = $request->abi_array;
		$save->decimals = $request->decimals;
		$save->gas_price = $request->gas_price;
		$save->save();

		return $save;
	}

	public static function view($id)
	{
		$list = ErcTokens::on('mysql2')->where('id',$id)->first();

		return $list;
	}

	public static function updated($request)
	{
		$save = ErcTokens::on('mysql2')->where('id',$request->id)->first();
		$save->name = $request->name;
		$save->contract_address = $request->contract_address;
		$save->abi_array = $request->abi_array;
		$save->decimals = $request->decimals;
		$save->gas_price = $request->gas_price;
		$save->status = $request->status;
		$save->save();

		return $save;
	}

}