<?php 
namespace App\Traits;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AdminTokenEthAddress;
use App\Traits\EthClass;

trait AdminTokenEth {

	public function ethcreate() {
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.blockcypher.com/v1/eth/main/addrs');
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

	public function create_admintoken_eth()
   	{
        $user_address = AdminTokenEthAddress::first();

        if(!is_object($user_address))
        {
          $ethaddress = $this->ethcreate();
          if(isset($ethaddress->address)){
          $ethtable = new AdminTokenEthAddress;
          $ethtable->address = "0x".$ethaddress->address;
          $pvtk = Crypt::encryptString($ethaddress->private);
          $pubk = Crypt::encryptString($ethaddress->public);
          $ethtable->narcanru = $pvtk.','.$pubk;
          $ethtable->balance = 0.00000000;
          $ethtable->save();
        
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


}