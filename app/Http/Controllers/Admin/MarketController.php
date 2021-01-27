<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Tradepair;
use App\Models\CompleteTrade;

class MarketController extends Controller
{
    public function index()
    {
        $market_lists= Tradepair::groupBy('cointwo')->get();        
        $first_maket_name = Tradepair::groupBy('cointwo')->value('cointwo');
        $trades = Tradepair::get();
        $pairCount =  Tradepair::count();
        $price = $this->last_Prices($pairCount);
        return view('market.index',[
        								'market_lists' 		=> $market_lists,
        								'first_maket_name' 	=> $first_maket_name,
        								'trades' 			=> $trades,
        								'price' 			=> $price,
        							]);
    }
    public function last_Prices($pairCount)
    {
        for($i=1;$i<=$pairCount;$i++)
        {
            $lastPrice = CompleteTrade::where('pair',$i)->orderby('id','desc')->first();
            if(isset($lastPrice->price))
            { 
                $last_price[]=$lastPrice->price;            
            } 
            else    
            {
                $last_price[] = 0;
            }
        }
        return $last_price;
    }
}
