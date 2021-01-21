<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;
use App\User;

use App\Models\UserWallet;
use App\Models\UserXrpAddress;
use App\Models\UserXrpAddressTable;
use App\Models\XrpAdminAddress;
use App\UserXrpTransaction;
use App\XrpAdminTransaction;
use App\Traits\Ripple; 

trait XrpClass
{
	use Ripple;
	function updateXrpTransaction($uid){	
        $sel = UserXrpAddress::where([['user_id', '=',$uid]])->first();
        if($sel){
			$address = $sel->address;
			$url = 'https://data.ripple.com/v2/accounts/'.$address.'/transactions';	
			$result = $this->cUrl_xrp($url);
			if($result['result']=='success' && $result['count'] > 0){	
				foreach($result['transactions'] as $trn){

					$rcc_value 		= $trn['tx']['Amount']/1000000;
					$time 			= $trn['date'];
					$recive_address = $trn['tx']['Destination'];
					$type 			= $trn['tx']['TransactionType'];
					$send_address 	= $trn['tx']['Account'];
					$fee 	        = $trn['tx']['Fee']/1000000;
					$txid = $trn['hash'];
					$is_txn = UserXrpTransaction::where('txid',$txid)->first();	
					if(!$is_txn){
						if($address == $recive_address){							
							$xrpaddress = new UserXrpTransaction;
						  	$xrpaddress->user_id = $sel->user_id;
						  	$xrpaddress->txid = $txid;
						  	$xrpaddress->type = 'received';
						  	$xrpaddress->recipient = $recive_address;
						  	$xrpaddress->sender = $send_address;
						  	$xrpaddress->amount = $rcc_value;
						  	$xrpaddress->fee = $fee;
						  	$xrpaddress->total_amount = $fee;
						  	$xrpaddress->confirmations = 20;
						  	$xrpaddress->created_at = date('Y-m-d H:i:s',strtotime($time));
						  	$xrpaddress->updated_at = date('Y-m-d H:i:s');
						  	$save=$xrpaddress->save();
						  	//$this->createUserXrpTransaction($sel->user_id,$rcc_value);
						  	$this->cron_userxrp_credit_balance($uid,$rcc_value);
						  	//$balance = $this->xrpbalanceupdate($address);
						  	// if($balance > 20){
						  	// 	$amt = bcsub($balance,20,8);
						  	// 	$this->createusertrn_xrp($uid,$amt);
						  	// }						  	
						}else{
							// $xrpaddress = new UserXrpTransaction;
						 //  	$xrpaddress->user_id = $sel->user_id;
						 //  	$xrpaddress->txid = $txid;
						 //  	$xrpaddress->type = 'send';
						 //  	$xrpaddress->recipient = $recive_address;
						 //  	$xrpaddress->sender = $send_address;
						 //  	$xrpaddress->amount = $rcc_value;
						 //  	$xrpaddress->fees = $fee;
						 //  	$xrpaddress->created_at = date('Y-m-d H:i:s',strtotime($time));
						 //  	$xrpaddress->updated_at = date('Y-m-d H:i:s');
						 //  	$save=$xrpaddress->save();
						}						
					} else {
						
					}
					
				}
			}
			return true;
			
        }else{
			return "No Address Found!";
		}
	}
	function update_all_user_xrp_transaction(){
		global $setkey, $iv, $dir;
        $select_user = UserXrpAddress::get();
        if($select_user)
        {
			foreach($select_user as $list){				
				$this->updateXrpTransaction($list->user_id);
				sleep(3);
			}           
			return true;
        }
	}
	function cUrl_xrp($url) {
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	$result = curl_exec($ch);
    	if (curl_errno($ch)) {
    		$result = 'Error:' . curl_error($ch);
    	}
    	curl_close($ch);
    	return json_decode($result, true);
    }
    function cron_userxrp_credit_balance($uid,$amount){
    	$userbalance = Wallet::where(['uid' =>$uid])->where('currency','XRP')->first();  

        if($userbalance) {             
            $total = bcadd($amount, $userbalance->balance,8); 
            Wallet::where(['uid'=> $uid])->where('currency','XRP')->update(['balance' => $total,'site_balance' => $total, 'updated_at' => date('Y-m-d H:i:s')]);
        } else { 

        	$bal = new Wallet();
        	$bal->uid = $uid;
        	$bal->currency = 'XRP';
        	$bal->balance = $amount;
        	$bal->main_balance = 0;
        	$bal->site_balance = $amount;
        	$bal->save();
        }
    }
     public function create_user_xrp($id)
   	{
        $userxrpaddress = UserXrpAddress::where('user_id',$id)->first();
	    if($userxrpaddress == '' || $userxrpaddress == null)
	    {
 		  $randnum = rand(100000,999999); 
          $xrpaddress = new UserXrpAddress;
          $xrpaddress->user_id = $id;
          $xrpaddress->address = 'rscVTNr24NDEY71a4kSgYmBjkiq2G7FyCm';
          $xrpaddress->credential = '012';
          $xrpaddress->xrp_tag = $randnum;
          $xrpaddress->balance = 0.00000000;  
          $save=$xrpaddress->save();

          $xrpaddress = new UserXrpAddressTable;
          $xrpaddress->setConnection('mysql2');
          $xrpaddress->user_id = $id;
          $xrpaddress->address = 'rscVTNr24NDEY71a4kSgYmBjkiq2G7FyCm';
		  $xrpaddress->balance = 0.00000000;
		  $xrpaddress->xrp_tag = $randnum;
          $save=$xrpaddress->save();
	      if($save)
	      {


      $check_wallet = UserWallet::where('user_id',$id)->where('currency','XRP')->first();
      if(is_object($check_wallet)){

        $check_wallet->mukavari ="0x".$ethaddress->address;
        $check_wallet->save();

      }else{
        UserWallet::create([
          'user_id' => $id,
          'mukavari' => 'rscVTNr24NDEY71a4kSgYmBjkiq2G7FyCm',
          'balance' => 0,
          'currency' => 'XRP',
        ]);
      }


	        return $xrpaddress->address;
	      }
	      else
	      {
	        return "error";
		  }
		
	    }

	    return $userxrpaddress->address;
    
   	}
   	public function createusertrn_xrp($uid,$amount){
   		$private = UserXrpAddress::where([['user_id', '=',$uid]])->first();
        $toaddress = $this->xrp_admin_address_get();
        $fromaddress = $private->address;
        if($fromaddress){
	      $pvtkey = Crypt::decryptString($private->narcanru);
	      $fee=0.0001;      
	      $send = $this->sendxrp($toaddress, $amount, $fromaddress,$pvtkey, $fee);
	      return $send;
	    }
	    return true;
   	}
   	public function createadmintrn_xrp($address,$amount){
   		$private = XrpAdminAddress::where([['id', '=',1]])->first();
	    $toaddress = $address;
	    $fromaddress = $private->address;
	    if($fromaddress){
	      $pvtkey = Crypt::decryptString($private->narcanru);
	      $fee=0.000012;
	      $result = $this->sendxrp($toaddress, $amount, $fromaddress,$pvtkey, $fee);
	      return $result;
	    }
	    return true;
   	}
   	function xrp_admin_address_get(){
    	$sel = XrpAdminAddress::where([['user_id', '=', 1]])->first();
    	return $sel->address;
    }
    function xrpbalanceupdate($address){
    	$url = 'https://data.ripple.com/v2/accounts/'.$address.'/balances?currency=XRP';	
		$data = self::cUrl_xrp($url);
		$balance =0;
		if($data['result']=='success'){
			$balance= $data['balances'][0]['value'];
			if($balance){
				UserXrpAddress::where(['address'=> $address])->update(['available_balance' => $balance, 'updated_at' => date('Y-m-d H:i:s')]);					
			}else{
				return 'Invalid Address! No record Found on db!';
			}			
		}
		return $balance;
    }

}