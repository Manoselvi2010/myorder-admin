<?php 
namespace App\Traits;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Traits\BtcClass;
use App\Traits\EthClass;
use App\Traits\LtcClass;
use App\Traits\XrpClass;


trait AddressCreation {

	use BtcClass, EthClass, LtcClass, XrpClass;

	public function userAddressCreation($id)
	{
 		$btcAddress = $this->btc_user_address_create($id);
 		$ethAddress = $this->create_user_eth($id);
 		$xrpaddress = $this->create_user_xrp($id);
 		$ltcAddress = $this->ltc_user_address_create($id);
	
		if(isset($btcAddress) && isset($ethAddress) && isset($ltcAddress) && isset($xrpaddress) )
		// if(isset($UserWallet))
		{
			return 1;
		}
		else
		{
			return 0;
		}
		
	}
}