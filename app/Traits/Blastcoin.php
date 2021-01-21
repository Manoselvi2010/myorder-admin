<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;
use App\User;
use App\Models\UserWallet;
use App\Models\EthAdminAddress;
use App\Models\UserBlastAddressTable;
use App\UserEthTransaction;
use App\EthAdminTransaction;
use App\Models\UserBlastAddress;

trait Blastcoin
{

    private $ch;
    private $params;
    private $result;
    private $url_link = "https://insight.bitpay.com/api/";
    private function _callblast($params){
        $this->ch = curl_init();
        $this->params = $params;
        // curl_setopt($this->ch, CURLOPT_URL, "http://63.209.32.63:8085");
        curl_setopt($this->ch, CURLOPT_URL, "http://62.171.168.72:8340");
        // curl_setopt($this->ch, CURLOPT_URL, "http://128.199.211.12:8085");
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->params));
        $headers = array();
        $headers[] = "Content-Type : application/json";
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        $this->result = curl_exec($this->ch);
        if (curl_errno($this->ch)) {
            echo 'Error:' . curl_error($this->ch);
        }
        curl_close($this->ch);
        return json_decode($this->result);
    }

	public function create_user_blast($id)
   	{

        $user_address = UserBlastAddress::where('user_id',$id)->first();
        if(!is_object($user_address))
        {
         
          $ethaddress = $this->createaddress_blast();
          if(isset($ethaddress->address)){
          $ethtable = new UserBlastAddress;
          $ethtable->user_id = $id;
          $ethtable->address = $ethaddress->address;
          $ethtable->balance = 0.00000000;
          $ethtable->save();

          $ethtable = new UserBlastAddressTable;
          $ethtable->setConnection('mysql2');
          $ethtable->user_id = $id;
          $ethtable->address = $ethaddress->address; 
          $ethtable->balance = 0.00000000;
          $ethtable->save();

        $check_wallet = UserWallet::where('user_id',$id)->where('currency','BLAST')->first();
      if(is_object($check_wallet)){

        $check_wallet->mukavari =$ethaddress->address;
        $check_wallet->save();

      }else{
        UserWallet::create([
          'user_id' => $id,
          'mukavari' => $ethaddress->address,
          'balance' => 0,
          'currency' => 'BLAST',
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

    
    public function createaddress_blast(){
        $params = array("method" => "create_address");
        if(!empty($params)){
            return $this->_callblast($params);
        }
    }


    public function history_blast(){
        $params = array("method" => "transacrion_his");
        if(!empty($params)){
            return $this->_callblast($params);
        }
    }

    public function cUrlssblast($url, $postfilds=null){
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

    function cUrlblast($url) {
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
 
    function blast_user_credit_balance($uid,$amount){
    	$currency ='BLAST';
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