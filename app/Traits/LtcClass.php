<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\User;

use App\Models\UserWallet;
use App\Models\UserBtcAddress;
use App\Models\UserLtcAddress;
use App\Models\UserBtcAddressTable;
use App\Models\UserLtcAddressTable;
use App\Models\BtcAdminAddress;
use App\UserBtcTransaction;
use App\AdminBtcTransaction;
use App\Traits\Bitcoin;
use App\Traits\Litecoin;

trait LtcClass
{
	use Litecoin;

	public function ltc_user_address_create($uid) {
	    
    $user_address = UserLtcAddress::where('user_id',$uid)->first();

// dd($user_address);
    if(!is_object($user_address))
    {
      $ltc = $this->createaddress_ltc();

  	  $address = $ltc->address;
      $publickey = Crypt::encryptString($ltc->publickey);
      $wif = Crypt::encryptString($ltc->wif);
      $privatekey = Crypt::encryptString($ltc->privatekey);
      
      $ltcaddress = new UserLtcAddressTable; 
      $ltcaddress = new UserLtcAddress;
      $credential = $publickey.','.$wif.','.$privatekey;
      
      $ltcaddress->user_id = $uid;
      $ltcaddress->address = $address;
      $ltcaddress->narcanru = $credential;
      $ltcaddress->balance = 0.00000000;
      $ltcaddress->save();

      $ltcaddress = new UserLtcAddress;
      $ltcaddress->setConnection('mysql2');
      $ltcaddress->user_id = $uid;
      $ltcaddress->address = $address; 
      $ltcaddress->balance = 0.00000000;
      $ltcaddress->save();



      $check_wallet = UserWallet::where('user_id',$uid)->where('currency','LTC')->first();
      if(is_object($check_wallet)){

        $check_wallet->mukavari = $address;
        $check_wallet->save();

      }else{
        UserWallet::create([
          'user_id' => $uid,
          'mukavari' => $address,
          'balance' => 0,
          'currency' => 'LTC',
        ]);
      }


      return $address;
    }
    else{
      return $user_address->address;
    }


   	
	}


  
  public  function ltcUserTransactions($uid)
  {
    $addr = UserLtcAddress::where('user_id', $uid)->first();
    if($addr){
      $tran = $this->getTransactions($addr->address);
      if($tran){
        foreach($tran->txs as $transaction)
        {
          $txid = $transaction->txid;
          $from = $transaction->vin[0]->addr;
          $amount = $transaction->vout[0]->value;
          $recive_address = $addr->address;
          $time = $transaction->time;
          $confirm = $transaction->confirmations;
          if($from != $recive_address){
            $is_txn = UserLtcTransaction::where('txid',$txid)->first();
            if(!$is_txn){
              $userBtcTransaction = new UserLtcTransaction;
              $userBtcTransaction->user_id = $uid;
              $userBtcTransaction->type = 'received';
              $userBtcTransaction->recipient = $recive_address;
              $userBtcTransaction->sender = $from;
              $userBtcTransaction->amount = $amount;
              $userBtcTransaction->confirmations = $confirm;
              $userBtcTransaction->txid = $txid;
              $userBtcTransaction->created_at = $time;
              $userBtcTransaction->save();
              $this->cron_userltc_credit_balance($uid,$amount);
              $amt = bcsub($amount,0.0001,8);
              //$this->createUserBtcTransaction($uid,$amt);
              return $this->createUserLtcTransaction($uid,$amt);
            }
          }

        }
      }
      return true;
        
    }else{
      return "No address";
    }
    
  }
  
  
//   public  function ltcAdminTransactions()
//   {
//     $addr = BtcAdminAddress::where('id', 1)->first();
//     if($addr){
//       $tran = $this->getTransactions($addr->address);
//       if(!empty($tran)){
//         foreach($tran->txs as $transaction)
//         {
//           $txid = $transaction->txid;
//           $from = $transaction->vin[0]->addr;
//           $amount = $transaction->vout[0]->value;
//           $recive_address = $addr->address;
//           $time = $transaction->time;
//           $confirm = $transaction->confirmations;
//           if($from){
//             $is_txn = BtcAdminTransaction::where('txid',$txid)->first();
//             if(!$is_txn){
//               $userBtcTransaction = new BtcAdminTransaction;
//               $userBtcTransaction->uid = 1;
//               $userBtcTransaction->type = 'received';
//               $userBtcTransaction->recipient = $recive_address;
//               $userBtcTransaction->sender = $from;
//               $userBtcTransaction->amount = $amount;
//               $userBtcTransaction->confirmations = $confirm;
//               $userBtcTransaction->txid = $txid;
//               $userBtcTransaction->created_at = $time;
//               $userBtcTransaction->save();
//               return "Balance updated!";
//             }
//           }

//         }
//       }
//       return true;
        
//     }else{
//       return "No address";
//     }
    
//   }

  function update_ltc_balance($addr){
      return $this->getBalance($addr);
  }


  function cron_userltc_credit_balance($uid,$amount){
    $currency ='LTC';
    $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=',$currency]])->first();
    if($userbalance) {
      $total = bcadd($amount, $userbalance->balance,8);
      Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $total], ['updated_at' => date('Y-m-d H:i:s',time())]);
    } else {
      Wallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $amount, 'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
    }
      return  true;
    }
    
    
  function update_all_user_ltc_transaction(){
    $select_user = UserLtcAddress::get();
    if($select_user)
    {
      foreach($select_user as $list){       
        $this->UserLtcTransaction($list->user_id);    
      }           
      return true;
    }

  }
  
  
  function createUserLtcTransaction($uid,$amt){
    $private = UserLtcAddress::where([['user_id', '=',$uid]])->first();
    $toaddress = $this->ltc_admin_address_get();
    $fromaddress = $private->address;
    $credential = explode(',',$private->narcanru);
    if($fromaddress){
      $pvtkey = Crypt::decryptString($credential[2]);
      $fee=0.0001;      
      $send = $this->send($toaddress, $amt, $fromaddress,$pvtkey, $fee);
      return $send;
    }
    return true;
  }
  
  
  function createAdminLtcTransaction($address,$amt){
    $private = LtcAdminAddress::where([['id', '=',1]])->first();
    $toaddress = $address;
    $fromaddress = $private->address;
    $credential = explode(',',$private->narcanru);
    if($fromaddress){
      $pvtkey = Crypt::decryptString($credential[2]);
      $fee=0.0001;
      $this->send($toaddress, $amt, $fromaddress,$pvtkey, $fee);
      return "Successfully transferred!";
    }
    return true;
  }
  
  function ltc_admin_address_get(){
    $sel = LtcAdminAddress::where([['id', '=', 1]])->first();
    return $sel->address;
  }
  
  function userbalance_ltc($uid){
    $currency ='LTC';
    $private = UserLtcAddress::where([['user_id', '=',$uid]])->first();
    if($private){
      $address = $private->address;
      $balance = $this->getBalance($address);
      UserbtcAddress::where(['user_id'=> $uid])->update(['balance' => $balance, 'updated_at' => date('Y-m-d H:i:s',time())]);
    }
    return true;
  }
  
  function Adminbalance_ltc(){
    $private = LtcAdminAddress::where([['id', '=',1]])->first();
    if($private){
      $address = $private->address;
      $balance = $this->getBalance($address);
      UserLtcAddress::where(['id'=> 1])->update(['balance' => $balance, 'updated_at' => date('Y-m-d H:i:s',time())]);
    }
    return true;
  }  

}