<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwaOption extends Model
{
    protected $table = 'twofa_option';

    public static function list()
	{
		$list = TwaOption::on('mysql2')->get();

		return $list;
	}

	public static function enable_list()
	{
		$list = TwaOption::on('mysql2')->where('status',1)->get();

		return $list;
	}

	public static function add($request)
	{
		$save = new TwaOption();
		$save->setConnection('mysql2');
		$save->name = $request->name;
		$save->save();

		return $save;
	} 

	public static function view($id)
	{
		$list = TwaOption::on('mysql2')->where('id',$id)->first();

		return $list;
	}

	public static function updated($request)
	{
		$save = TwaOption::on('mysql2')->where('id',$request->id)->first();
		$save->name = $request->name;		
		$save->status = $request->two_option;
		$save->save();

		return $save;
	}
}
