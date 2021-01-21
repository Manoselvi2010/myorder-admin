<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\User;
use App\Models\UserWallet;
use App\Models\UserBtcAddress;
use App\Models\UserBtcAddressTable;
use App\Models\BtcAdminAddress;
use App\UserBtcTransaction;
use App\AdminBtcTransaction;
use App\Traits\Bitcoin;

trait BtcClass
{
	use Bitcoin;

	public function btc_user_address_create($uid) {

    echo $uid;

    echo "\n";
   
    $user_address = UserBtcAddress::where('user_id',$uid)->first();

    if(!is_object($user_address))
    {
      $btc = $this->createaddress_btc();
  	  $address = $btc->address;
      $publickey = Crypt::encryptString($btc->publickey);
      $wif = Crypt::encryptString($btc->wif);
      $privatekey = Crypt::encryptString($btc->privatekey);
      $btcaddress = new UserBtcAddress;
      $credential = $publickey.','.$wif.','.$privatekey;
      $btcaddress->user_id = $uid;
      $btcaddress->address = $address;
      $btcaddress->narcanru = $credential;
      $btcaddress->balance = 0.00000000;
      $btcaddress->save();

      $btcaddress = new UserBtcAddressTable; 
      $btcaddress->setConnection('mysql2');
      $btcaddress->user_id = $uid;
      $btcaddress->address = $address; 
      $btcaddress->balance = 0.00000000;
      $btcaddress->save();

      $check_wallet = UserWallet::where('user_id',$uid)->where('currency','BTC')->first();
      if(is_object($check_wallet)){

        $check_wallet->mukavari = $address;
        $check_wallet->save();

      }else{
        UserWallet::create([
          'user_id' => $uid,
          'mukavari' => $address,
          'balance' => 0,
          'currency' => 'BTC',
        ]);
      }

      echo 'created';

      return $address;
    }
    else{
      echo 'already address create';
      return $user_address->address;
    }

	}

  public function btc_admin_address_create() {
    $btc = $this->createaddress_btc();
    $address = $btc->address;
    $publickey = Crypt::encryptString($btc->publickey);
    $wif = Crypt::encryptString($btc->wif);
    $privatekey = Crypt::encryptString($btc->privatekey);
    $btcaddress = new BtcAdminAddress;
    $credential = $publickey.','.$wif.','.$privatekey;
    $btcaddress->address = $address;
    $btcaddress->narcanru = $credential;
    $btcaddress->balance = 0.00000000;
    $btcaddress->save();    
    return true;
  }
  public  function btcUserTransactions($uid)
  {
    $addr = UserbtcAddress::where('user_id', $uid)->first();
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
            $is_txn = UserBtcTransaction::where('txid',$txid)->first();
            if(!$is_txn){
              $userBtcTransaction = new UserBtcTransaction;
              $userBtcTransaction->user_id = $uid;
              $userBtcTransaction->type = 'received';
              $userBtcTransaction->recipient = $recive_address;
              $userBtcTransaction->sender = $from;
              $userBtcTransaction->amount = $amount;
              $userBtcTransaction->confirmations = $confirm;
              $userBtcTransaction->txid = $txid;
              $userBtcTransaction->created_at = $time;
              $userBtcTransaction->save();
              $this->cron_userbtc_credit_balance($uid,$amount);
              $amt = bcsub($amount,0.0001,8);
              //$this->createUserBtcTransaction($uid,$amt);
              return $this->createUserBtcTransaction($uid,$amt);
            }
          }

        }
      }
      return true;
        
    }else{
      return "No address";
    }
    
  }
  public  function btcAdminTransactions()
  {
    $addr = BtcAdminAddress::where('id', 1)->first();
    if($addr){
      $tran = $this->getTransactions($addr->address);
      if(!empty($tran)){
        foreach($tran->txs as $transaction)
        {
          $txid = $transaction->txid;
          $from = $transaction->vin[0]->addr;
          $amount = $transaction->vout[0]->value;
          $recive_address = $addr->address;
          $time = $transaction->time;
          $confirm = $transaction->confirmations;
          if($from){
            $is_txn = BtcAdminTransaction::where('txid',$txid)->first();
            if(!$is_txn){
              $userBtcTransaction = new BtcAdminTransaction;
              $userBtcTransaction->uid = 1;
              $userBtcTransaction->type = 'received';
              $userBtcTransaction->recipient = $recive_address;
              $userBtcTransaction->sender = $from;
              $userBtcTransaction->amount = $amount;
              $userBtcTransaction->confirmations = $confirm;
              $userBtcTransaction->txid = $txid;
              $userBtcTransaction->created_at = $time;
              $userBtcTransaction->save();
              return "Balance updated!";
            }
          }

        }
      }
      return true;
        
    }else{
      return "No address";
    }
    
  }

  function update_btc_balance($addr){
      return $this->getBalance($addr);
  }


  function cron_userbtc_credit_balance($uid,$amount){
    $currency ='BTC';
    $userbalance = UserWallet::where([['uid', '=', $uid], ['currency', '=',$currency]])->first();
    if($userbalance) {
      $total = bcadd($amount, $userbalance->balance,8);
      UserWallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $total], ['updated_at' => date('Y-m-d H:i:s',time())]);
    } else {
      UserWallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $amount, 'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
    }
      return  true;
    }
  function update_all_user_btc_transaction(){
    $select_user = UserbtcAddress::get();
    if($select_user)
    {
      foreach($select_user as $list){       
        $this->btcUserTransactions($list->user_id);    
      }           
      return true;
    }

  }
  function createUserBtcTransaction($uid,$amt){
    $private = UserbtcAddress::where([['user_id', '=',$uid]])->first();
    $toaddress = $this->btc_admin_address_get();
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
  function createAdminBtcTransaction($address,$amt){
    $private = BtcAdminAddress::where([['id', '=',1]])->first();
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
  function btc_admin_address_get(){
    $sel = BtcAdminAddress::where([['id', '=', 1]])->first();
    return $sel->address;
  }
  function userbalance_btc($uid){
    $currency ='BTC';
    $private = UserbtcAddress::where([['user_id', '=',$uid]])->first();
    if($private){
      $address = $private->address;
      $balance = $this->getBalance($address);
      UserbtcAddress::where(['user_id'=> $uid])->update(['balance' => $balance, 'updated_at' => date('Y-m-d H:i:s',time())]);
    }
    return true;
  }
  function Adminbalance_btc(){
    $private = BtcAdminAddress::where([['id', '=',1]])->first();
    if($private){
      $address = $private->address;
      $balance = $this->getBalance($address);
      UserbtcAddress::where(['id'=> 1])->update(['balance' => $balance, 'updated_at' => date('Y-m-d H:i:s',time())]);
    }
    return true;
  }  

}