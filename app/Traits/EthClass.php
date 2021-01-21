<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;
use App\User;
use App\Models\UserWallet;
use App\Models\EthAdminAddress;
use App\Models\UserEthAddressTable;
use App\UserEthTransaction;
use App\EthAdminTransaction;
use App\Models\UserEthAddress;

trait EthClass
{
	public function ethcreate() {

        $tokenblock = env('ETH_TOKEN_BLOCK','db9832bebd4e464e9b46c596d32a5b54');
        $url = 'https://api.blockcypher.com/v1/eth/main/addrs?token='.$tokenblock;

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
		return json_decode($result);
	}

	public function create_user_eth($id)
   	{
        $user_address = UserEthAddress::where('user_id',$id)->first();
        if(!is_object($user_address))
        {
          $ethaddress = $this->ethcreate();
          if(isset($ethaddress->address)){
          $ethtable = new UserEthAddress;
          $ethtable->user_id = $id;
          $ethtable->address = "0x".$ethaddress->address;
          $pvtk = Crypt::encryptString($ethaddress->private);
          $pubk = Crypt::encryptString($ethaddress->public);
          $ethtable->narcanru = $pvtk.','.$pubk;
          $ethtable->balance = 0.00000000;
          $ethtable->save();

          $ethtable = new UserEthAddressTable;
          $ethtable->setConnection('mysql2');
          $ethtable->user_id = $id;
          $ethtable->address = "0x".$ethaddress->address; 
          $ethtable->balance = 0.00000000;
          $ethtable->save();

        $check_wallet = UserWallet::where('user_id',$id)->where('currency','ETH')->first();
      if(is_object($check_wallet)){

        $check_wallet->mukavari ="0x".$ethaddress->address;
        $check_wallet->save();

      }else{
        UserWallet::create([
          'user_id' => $id,
          'mukavari' => "0x".$ethaddress->address,
          'balance' => 0,
          'currency' => 'ETH',
        ]);
      }

    $check_wallet = UserWallet::where('user_id',$id)->where('currency','USDT')->first();
      if(is_object($check_wallet)){
        
        $check_wallet->mukavari ="0x".$ethaddress->address;
        $check_wallet->save();

      }else{
        UserWallet::create([
          'user_id' => $id,
          'mukavari' => "0x".$ethaddress->address,
          'balance' => 0,
          'currency' => 'USDT',
        ]);
      }


       $check_wallet = UserWallet::where('user_id',$id)->where('currency','DAI')->first();
      if(is_object($check_wallet)){
        
        $check_wallet->mukavari ="0x".$ethaddress->address;
        $check_wallet->save();

      }else{
        UserWallet::create([
          'user_id' => $id,
          'mukavari' => "0x".$ethaddress->address,
          'balance' => 0,
          'currency' => 'DAI',
        ]);
      }
        
          return $ethaddress->address;
      }else{
        return 'No address';
      }
        }
        else{
          return $user_address->address;
        }
            
    }

   	function createUserEthTransaction($uid, $amount)
    {  
        $tokenblock = env('ETH_TOKEN_BLOCK',null);
        
        $private = UserEthAddress::where([['user_id', '=',$uid]])->first();
        $toaddress = $this->eth_admin_address_get();
        $fromaddress = $private->address;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.blockcypher.com/v1/eth/main/txs/new?token=$tokenblock");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"inputs\":[{\"addresses\": [\"$fromaddress\"]}],\"outputs\":[{\"addresses\": [\"$toaddress\"], \"value\": $amount}], \"gas_limit\" : 21000, \"gas_price\" : 20000000000 }");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $send = json_decode($result);

        if($send->errors){
            return 'Insufficient Balance';
            exit();
        } elseif($send->error){
            return $send->error;
            exit();
        } elseif($send->tx){
            $f_address = $fromaddress;
            $t_address = $toaddress;
            $from_addr = $f_address;
            $to_addr = $t_address;
            if($private){
                
                $privatekey = Crypt::decryptString($private->pvtk);
                $data = rtrim($result,"}");
                $tosign_count = count($send->tosign);
                $outputs = '';
                for($i = 0; $i < $tosign_count; $i++)
                {
                    $tosign = $send->tosign[$i];
                    $output = shell_exec($dir."btcutils/signer/signer $tosign $privatekey 2>&1");
                    $outputs .= '"'.trim($output).'",';
                }
                $outputs = trim($outputs, ", ");
                $tx = $data.', "signatures" : ['.$outputs.' ] } ';
                $data = $this->sendEthTransaction($tx,$tokenblock);
                
                if($data->error){
                    return 'Transaction failed';
                } 
                elseif($data->tx){
	                $hash = $data->tx->hash;
	                $total = $this->weitoeth($data->tx->total);
	                $fees = $this->weitoeth($data->tx->fees);

	                $ethtransaction = new UserEthTransaction;
	                $ethtransaction->user_id = $private->uid;
	                $ethtransaction->type = 'send';
	                $ethtransaction->recipient = $to_addr;
	                $ethtransaction->sender = $from_addr;
	                $ethtransaction->amount = $total;
	                $ethtransaction->confirmations = $fees;
	                $ethtransaction->txid = $hash;
	                $ethtransaction->created_at = date('Y-m-d H:i:s');
	                $ethtransaction->updated_at = date('Y-m-d H:i:s');
	                $txinsert = $ethtransaction->save();               
	                if($txinsert)
	                {
	                    return 'Success';
	                }
	                else
	                {
	                    return false;
	                }
            	}
        	}
        }
    }
    
    function createAdminEthTransaction($toaddress, $amount)
    {  
        $tokenblock = env('ETH_TOKEN_BLOCK',null);
        $private = EthAdminAddress::where([['uid', '=',1]])->first();
        $fromaddress = $this->eth_admin_address_get();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.blockcypher.com/v1/eth/main/txs/new?token=$tokenblock");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"inputs\":[{\"addresses\": [\"$fromaddress\"]}],\"outputs\":[{\"addresses\": [\"$toaddress\"], \"value\": $amount}], \"gas_limit\" : 21000, \"gas_price\" : 20000000000 }");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $send = json_decode($result);
        //dd($send);
        if($send->error){
            return 'Insufficient Balance';
            exit();
        } elseif($send->error){
            return $send->error;
            exit();
        } elseif($send->tx){
            $f_address = $fromaddress;
            $t_address = $toaddress;
            $from_addr = $f_address;
            $to_addr = $t_address;
            if($private){
                
                $privatekey = Crypt::decryptString($private->pvtk);
                $data = rtrim($result,"}");
                $tosign_count = count($send->tosign);
                $outputs = '';
                for($i = 0; $i < $tosign_count; $i++)
                {
                    $tosign = $send->tosign[$i];
                    $output = shell_exec($dir."btcutils/signer/signer $tosign $privatekey 2>&1");
                    $outputs .= '"'.trim($output).'",';
                }
                $outputs = trim($outputs, ", ");
                $tx = $data.', "signatures" : ['.$outputs.' ] } ';
                $data = $this->sendEthTransaction($tx,$tokenblock);
                
                if($data->error){
                    return 'Transaction failed';
                } 
                elseif($data->tx){
	                $hash = $data->tx->hash;
	                $total = $this->weitoeth($data->tx->total);
	                $fees = $this->weitoeth($data->tx->fees);

	                $ethtransaction = new EthAdminTransaction;
	                $ethtransaction->uid = 1;
	                $ethtransaction->type = 'send';
	                $ethtransaction->recipient = $to_addr;
	                $ethtransaction->sender = $from_addr;
	                $ethtransaction->amount = $total;
	                $ethtransaction->txid = $hash;
	                $ethtransaction->created_at = date('Y-m-d H:i:s');
	                $ethtransaction->updated_at = date('Y-m-d H:i:s');
	                $txinsert = $ethtransaction->save();               
	                if($txinsert)
	                {
	                    return 'Success';
	                }
	                else
	                {
	                    return false;
	                }
            	}
        	}
        }
    }

    function wei($amount){
        return number_format((1000000000000000000 * $amount), 0,'.','');
    }

    function weitoeth($amount){
        return $amount / 1000000000000000000;
    }

    function sendEthTransaction($tx,$tokenblock)
    {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.blockcypher.com/v1/eth/main/txs/send?token=$tokenblock");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $tx);
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return json_decode($result);
    }

    function updateETHBalance($id)
    {
            
        $sel = UserEthAddress::where([['uid', '=', $id]])->first();
        if($sel){
            $address1 = $sel->address;
            $address = $sel->address; 
            $url = "https://api.etherscan.io/api?module=account&action=balance&address=".$address;
            $balance = self::cUrlss($url);
            if(isset($balance['result'])){
                if(isset($balance['balance'])){
                    $data = UserEthAddress::where(['address'=>$address])->update(['available_balance' => $this->weitoeth($balance['result'])]);
                    if($data){                        
                        return true;
                    }
                }
            } 
        }
    }
    function ethTxn($uid){
        $sel = UserEthAddress::where([['user_id', '=', $uid]])->first();
        if($sel){
            $address = $sel->address;        
            $url = "http://api.etherscan.io/api?module=account&action=txlist&address=0x".$address."&startblock=0&endblock=99999999&sort=asc";
            $balance = $this->cUrlss($url);
            $count = count($balance['result']);
            if($count > 0)
            {
                $result_data = $balance['result'];
                //return $count;
                for($i = 0; $i < $count; $i++)
                {
                    $data = $result_data[$i];
                    $tx_hash = $data['hash'];
                    $from = str_replace('0x', '', $data['from']);
                    $to = str_replace('0x', '', $data['to']);               
                    $total = self::weitoeth($data['value']);
                    $is_txn = UserEthTransaction::where('txid',$tx_hash)->first();
                    if(!$is_txn && $tx_hash!=NULL)
                    {
                        if($address == $from)
                        {
                            $type = 'send';
                        }
                        else
                        {
                            $total = bcmul($total,1,8);
                            $type = 'received';
                            $ethaddress = new UserEthTransaction;
                            $ethaddress->user_id = $uid;
                            $ethaddress->txid = $tx_hash;
                            $ethaddress->type =  'received';
                            $ethaddress->recipient = $to;
                            $ethaddress->sender = $from;
                            $ethaddress->amount = $total;
                            $ethaddress->fees = 0.00042;
                            $ethaddress->created_at = date('Y-m-d H:i:s');
                            $save=$ethaddress->save();
                            //$this->createUserEthTransaction($select_user->user_id,$total);
                            $this->cron_user_credit_balance($uid,$total);
                        }                        
                    }
                }
            }
            return $address;
        }
        return true;
    }
    public function cUrlss($url, $postfilds=null){
         $this->url = $url;
         $this->ch = curl_init();
         curl_setopt($this->ch, CURLOPT_URL, $this->url);
         curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
         if(!is_null($postfilds)){
         curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postfilds);
         }
         if(strpos($this->url, '?') !== false){
         curl_setopt($this->ch, CURLOPT_POST, 1);
         }
         $headers = array('Content-Length: 0');
         $headers[] = "Content-Type: application/x-www-form-urlencoded";
         curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
         if (curl_errno($this->ch)) {
         $this->result = 'Error:' . curl_error($this->ch);
         } else {
         $this->result = curl_exec($this->ch);
         } 
         curl_close($this->ch);
         return json_decode($this->result, true);
    }
    function updateAdminETHTxnsBalance()
    {
        $sel = EthAdminAddress::where([['uid', '=', 1]])->first();
        if($sel){
            $address1 = $sel->address;
            $address = $sel->address;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.blockcypher.com/v1/eth/main/addrs/".$address1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $headers = array();
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $send = json_decode($result, true);
            
            if($send['final_balance'] < 0 || $send['final_balance'] == 0)
            {            	
                return true;
            }
            else
            {
                $uncofirm_count = $send['unconfirmed_n_tx'];
                $cofirm_count = count($send['txrefs']);
                $final_balance = $this->weitoeth($send['final_balance']);
                $update_balance = EthAdminAddress::where(['address'=>$address1])->update(['available_balance' => $final_balance]);
                if($update_balance)
                {
                    if($uncofirm_count > 0)
                    {
                        for($i = 0; $i <= $uncofirm_count; $i++)
                        {
                            $tx_hash = $send['unconfirmed_txrefs'][$i]['tx_hash'];
                            if($tx_hash)
                            {
                                $transaction = $this->txns($tx_hash);
                                $sender = $transaction['inputs']['0']['addresses']['0'];
                                $receiver = $transaction['outputs']['0']['addresses']['0'];
                                $fees = $this->weitoeth($transaction['fees']);
                                $total = $this->weitoeth($transaction['outputs']['0']['value']);
                                $select_user = EthAdminAddress::where('address', $receiver)->first();
                                if($select_user)
                                {
                                	$is_txn = EthAdminTransaction::where('txid',$tx_hash)->first();
                                    if(!$is_txn)
                                    {
                                       
                                    }
                                }
                            }
                        }
                    }
                    if($cofirm_count > 0)
                    {
                        for($i = 0; $i < $cofirm_count; $i++)
                        {
                            $tx_hash = $send['txrefs'][$i]['tx_hash'];
                            if($tx_hash)
                            {
                                $transaction = $this->txns($tx_hash);
                                $sender = $transaction['inputs']['0']['addresses']['0'];
                                $receiver = $transaction['outputs']['0']['addresses']['0'];
                                $fees = $this->weitoeth($transaction['fees']);
                                $total = $this->weitoeth($transaction['outputs']['0']['value']);
                                $confirmations = $transaction['confirmations'];
                               	$select_user = EthAdminAddress::where('address', $receiver)->first();
                                if($select_user)
                                {
                                    $is_txn = EthAdminTransaction::where('txid',$tx_hash)->first();
                                    if(!$is_txn)
                                    {
                                    	$ethaddress = new EthAdminTransaction;
									  	$ethaddress->user_id = $select_user->user_id;
									  	$ethaddress->txid = $tx_hash;
									  	$ethaddress->type =  'received';
									  	$ethaddress->recipient = $receiver;
									  	$ethaddress->sender = $sender;
									  	$ethaddress->amount = $total;
									  	$ethaddress->fees = $fees;
									  	$ethaddress->created_at = date('Y-m-d H:i:s');
									  	$save=$ethaddress->save();

                                        
                                    }
                                    else
                                    {
                                        //$update_txn = parent::dbRowUpdate(COIN_ETH_TRANSACTION, array('confirmations' => $confirmations), array('txid' => $tx_hash));
                                    }
                                }
                            }
                        }
                    }
                }
                return true;
            }
            return true;
        }
        return true;
    }
    function txns($tx)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.blockcypher.com/v1/eth/main/txs/$tx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }   
        curl_close($ch);
        $send = json_decode($result, true);
        return $send;
    }
    function cUrl($url) {
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
    function eth_admin_address_get(){
    	$sel = EthAdminAddress::where([['uid', '=', 1]])->first();
    	return $sel->address;
    }
    function cron_user_credit_balance($uid,$amount){
    	$currency ='ETH';
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=',$currency]])->first();
        if($userbalance) {
          $total = bcadd($amount, $userbalance->balance,8);
          Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $total], ['updated_at' => date('Y-m-d H:i:s',time())]);
        } else {
          Wallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $amount, 'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
        }
          return  true;
    }

}

?>