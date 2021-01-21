<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tradepair extends Model
{
    protected $table = 'tradepairs';

    public static function index($pair, $pair2)
    {
    	$details = Tradepair::on('mysql2')->where([['coinone', '=', $pair],['cointwo', '=', $pair2]])->orderBy('id', 'asc')->first();

    	return $details;
    }

    public static function pair()
    {
    	$pairs = Tradepair::on('mysql2')->orderBy('id', 'asc')->get();

    	return $pairs;
    }

    public static function pair_id($id)
    {
        $pairs = Tradepair::on('mysql2')->where('id',$id)->orderBy('id', 'asc')->first();

        return $pairs;
    }

    public static function firstPair()
    {
        $pairs = Tradepair::on('mysql2')->orderBy('id', 'asc')->first();

        return $pairs;
    } 

}
