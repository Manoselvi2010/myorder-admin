<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Commission;
use App\Models\UserWallet;
use App\Models\AdminBtcAddress;
use App\Models\AdminEthAddress;
use App\Models\AdminLtcAddress;
use App\Models\AdminBlastAddress;
use App\Models\AdminDogcoinAddress;
use App\Models\AdminXrpAddress;
use App\Models\AdminJadaxAddress;
use App\Models\AdminTokenEthAddress;
use App\Traits\Bitcoin;

class AdminWalletController extends Controller
{
	use Bitcoin;

	public function index()
	{ 

		$coinslist = Commission::get();

		foreach ($coinslist as $key => $value) {

			if($value->source == 'BTC'){

				$btc_address = AdminBtcAddress::first();		

					if(is_object($btc_address)){
						$address[$value->source] = $btc_address->address;
						$balance[$value->source] = $this->btcBalance($btc_address->address);
					}else{
						$address[$value->source] = 'Admin Address';
						$balance[$value->source] = 0;
					}

			}

			if($value->source == 'ETH'){

				$eth_address = AdminEthAddress::first();

				if(is_object($eth_address)){
						$address[$value->source] = $eth_address->address;
						$balance[$value->source] = $this->ethBalance($eth_address->address);
						
						
					}else{
						$address[$value->source] = 'Admin Address';
						$balance[$value->source] = 0;
				
					}
			}

			if($value->source == 'LTC'){
				$ltc_address = AdminLtcAddress::first();

					if(is_object($eth_address)){
						$address[$value->source] = $ltc_address->address;
						$balance[$value->source] = $this->ltcBalance($ltc_address->address);
					}else{
						$address[$value->source] = 'Admin Address';
						$balance[$value->source] = 0;
				
					}
			}

			if($value->source == 'XRP'){

				$xrp_address = AdminXrpAddress::first();

					if(is_object($xrp_address)){
						$address[$value->source] = $xrp_address->address;
						$balance[$value->source] = $this->ltcBalance($xrp_address->address);
					}else{
						$address[$value->source] = 'Admin Address';
						$balance[$value->source] = 0;
				
					}
			
			}

			if($value->source == 'DAI'){
					$eth_address = AdminEthAddress::first();

				if(is_object($eth_address)){
						$address[$value->source] = $eth_address->address;
						$balance[$value->source] = $this->tokenBalance($eth_address->address,'0xA0a19052aA80d7Fc258d24701b8F3c37dE70B925');
					}else{
						$address[$value->source] = 'Admin Address';
						$balance[$value->source] = 0;
				
					}
			}
			

			if($value->source == 'USDT'){
				$eth_address = AdminEthAddress::first();

				if(is_object($eth_address)){
						$address[$value->source] = $eth_address->address;
						$balance[$value->source] = $this->tokenBalance($eth_address->address,'0xdAC17F958D2ee523a2206206994597C13D831ec7');
					}else{
						$address[$value->source] = 'Admin Address';
						$balance[$value->source] = 0;
				
					}
			}
			
			
		}

		return view('wallet.list',[
			'address' => $address,
			'balance' => $balance
			]);
	} 

	public function btcBalance($address)
	{
		if(!empty($address)){
            $url_link = "https://chain.so/api/v2/get_address_balance/BTC/".$address;
            $balance = $this->cUrl1($url_link);  
   			if(isset($balance['data'])){
   				 return $balance['data']['confirmed_balance']; 
   				}else{
   					return 0;
   				}
        }else{
            return 0;
        }
	}

	public function ltcBalance($address)
	{
		if(!empty($address)){
            $url_link = "https://chain.so/api/v2/get_address_balance/LTC/".$address;
            $balance = $this->cUrl1($url_link);  
   			if(isset($balance['data'])){
   				 return $balance['data']['confirmed_balance']; 
   				}else{
   					return 0;
   				}
        }else{
            return 0;
        }
	}

	public function ethBalance($address)
	{
		$url = "https://api.etherscan.io/api?module=account&action=balance&address=".$address."&apikey=KSHMGIHSNC9GDF1IV1T3ZHDD473X3D5FG3";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        if (curl_errno($ch)) {
        $result = 'Error:' . curl_error($ch);
        } else {
        $result = curl_exec($ch);
        }
        curl_close($ch); 
        $dd = json_decode($result); 
        return $dd->result/1000000000000000000;
	}

	public function tokenBalance($address,$contract)
	{

		$url = "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contract."&address=".$address."&tag=latest&apikey=KSHMGIHSNC9GDF1IV1T3ZHDD473X3D5FG3";

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        if (curl_errno($ch)) {
        $result = 'Error:' . curl_error($ch);
        } else {
        $result = curl_exec($ch);
        }
        curl_close($ch); 
        $dd = json_decode($result); 
        // return $dd/1000000000000000000;
        return $dd->result/100000000;
	}

	public function usdttokenBalance($address,$contract)
	{

		$url = "https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=".$contract."&address=".$address."&tag=latest&apikey=KSHMGIHSNC9GDF1IV1T3ZHDD473X3D5FG3";

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        if (curl_errno($ch)) {
        $result = 'Error:' . curl_error($ch);
        } else {
        $result = curl_exec($ch);
        }
        curl_close($ch); 
        $dd = json_decode($result); 
        // return $dd/1000000000000000000;
        return $dd->result/1000000;
	}



	public function jadaxBalance($address)
	{
		$url = "https://api.tokenbalance.com/balance/0x94190e84A62c4e1fb4CDE76407a0dec59354395D/".$address;

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        if (curl_errno($ch)) {
        $result = 'Error:' . curl_error($ch);
        } else {
        $result = curl_exec($ch);
        }
        curl_close($ch); 
        $dd = json_decode($result); 
        // return $dd/1000000000000000000;
        return $dd;
	}

}