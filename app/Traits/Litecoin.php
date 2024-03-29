<?php
namespace App\Traits;
use App\Models\UserLtcAddress;
use App\Models\UserLtcAddressTable;
use Illuminate\Support\Facades\Crypt;

trait Litecoin 
{	
	private $ch_ltc;
	private $params_ltc;
	private $result_ltc;
	private $url_ltc = "https://insight.litecore.io/api/";
	private function _call_ltc($params_ltc){
		$this->ch_ltc = curl_init();
		$this->params = $params_ltc;
		// curl_setopt($this->ch_ltc, CURLOPT_URL, "http://134.122.112.240:8090");
		// curl_setopt($this->ch_ltc, CURLOPT_URL, "http://167.71.152.74:8086");//demosite ip
		curl_setopt($this->ch_ltc, CURLOPT_URL, "http://127.0.0.1:8086");//local
		curl_setopt($this->ch_ltc, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch_ltc, CURLOPT_POST, 1);
		curl_setopt($this->ch_ltc, CURLOPT_POSTFIELDS, json_encode($this->params));
		$headers = array();
		$headers[] = "Content-Type : application/json";
		curl_setopt($this->ch_ltc, CURLOPT_HTTPHEADER, $headers);
		$this->result_ltc = curl_exec($this->ch_ltc);
		if (curl_errno($this->ch_ltc)) {
			echo 'Error:' . curl_error($this->ch_ltc);
		}
		curl_close($this->ch_ltc);
		return json_decode($this->result_ltc);
	}
	// create address
	public function createaddress_ltc(){
		$params = array("method" => "create_address");
		if(!empty($params)){
			return $this->_call_ltc($params);
		}
	}

	public function createmsigaddress_ltc(){
		$params = array("method" => "create_multisig_address");
		if(!empty($params)){
			return $this->_call($params);
		}
	}
	private function utxo_ltc($address){
		if(!empty($address)){
			$url = $this->url_ltc."addr/$address/utxo?noCache=1";
			return $this->cUrl_ltc1($url);
		}
	}
	
	public function tx_ltc($txid){
		if(!empty($txid)){
			$url = $this->url_ltc."tx/$txid";
			return json_decode($this->cUrl_ltc1($url));
		}
	}
	public function getTransactions_ltc($address){
		if(!empty($address)){
			$url = $this->url_ltc."txs/?address=$address";
			return json_decode($this->cUrl_ltc1($url));
		}
	}
	
	public function getBalance_ltc($address){
		if(!empty($address)){
			$url = $this->url_ltc."addr/$address/balance";
			$balance = $this->cUrl_ltc1($url);
			return $this->sathositobtc($balance);
		}else{
			return 0;
		}
	}
	
	public function totalReceived_ltc($address){
		if(!empty($address)){
			$url = $this->url_ltc."addr/$address/totalReceived";
			$balance = $this->cUrl_ltc1($url);
			return $this->sathositobtc($balance);
		}
	}
	
	public function totalSent_ltc($address){
		if(!empty($address)){
			$url = $this->url_ltc."addr/$address/totalSent";
			$balance = $this->cUrl_ltc1($url);
			return $this->sathositobtc($balance);
		}
	}
	
	public function unconfirmedBalance_ltc($address){
		if(!empty($address)){
			$url = $this->url_ltc."addr/$address/unconfirmedBalance";
			$balance = $this->cUrl_ltc1($url);
			return $this->sathositobtc($balance);
		}
	}
	
	private function cUrl_ltc1($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$headers = array();
		$headers[] = "Accept: application/json, text/plain";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if (curl_errno($ch)) {
			echo $result = 'Error:' . curl_error($ch);
		} else {
			$result = curl_exec($ch);
		}
		curl_close($ch);
		return $result;
	}
	// send bitcoin
	public function send_ltc($to, $amount, $from=null,$pvtkey, $fee=null){
		$utxo = self::utxo_ltc($from);

		if(!empty($utxo)){
			$params = array(
				"method" => "create_rawtx",
				"fromaddr" => $from,
				"privatekey" => $pvtkey,
				"toaddr" => $to,
				"amount" => self::sathosi_ltc($amount),
				"fee" => self::sathosi_ltc($fee),
				"utxo" => $utxo
			);
			if(!empty($params)){
				$rawtx = $this->_call_ltc($params);
				if(!empty($rawtx)){
					$txid = $this->sendtxnltc($rawtx->rawtx);
				}
			}
		}else{
			return "Not send!";
		}
		
	}
	private function sathosi_ltc($amount){
		if(!empty($amount)){
			return 100000000 * $amount;
		}
	}
	
	private function sendtxnltc($rawtx){
		if(!empty($rawtx)){
			$url = "https://chain.so/api/v2/send_tx/LTC";
        	$ch = curl_init();
        	$params = array("tx_hex" => $rawtx);
        	curl_setopt($ch, CURLOPT_URL, $url);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        	curl_setopt($ch, CURLOPT_POST, 1);
        	$headers = array();
        	$headers[] = "Accept: application/json, text/plain";
        	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        	if(curl_errno($ch)) {
        		echo $result = 'Error:' . curl_error($ch);
        	} else {
        		$result = curl_exec($ch);
        	}
        	curl_close($ch);
        	return json_encode($result);
		}
	}

	public function create_user_ltc($id)
	{
		$user_address = UserLtcAddress::where('user_id',$id)->first();
	    if(count($user_address) == 0)
	    {
	      $btc = $this->createaddress_ltc();
	  	  $address = $btc->address;
	      $publickey = Crypt::encryptString($btc->publickey);
	      $wif = Crypt::encryptString($btc->wif);
	      $privatekey = Crypt::encryptString($btc->privatekey);
	      $btcaddress = new UserLtcAddress;
	      $credential = $publickey.','.$wif.','.$privatekey;
	      $btcaddress->user_id = $id;
	      $btcaddress->address = $address;
	      $btcaddress->narcanru = $credential;
	      $btcaddress->balance = 0.00000000;
	      $btcaddress->save();

	      $btcaddress = new UserLtcAddressTable; 
	      $btcaddress->setConnection('mysql2');
	      $btcaddress->user_id = $id;
	      $btcaddress->address = $address; 
	      $btcaddress->balance = 0.00000000;
	      $btcaddress->save();

	      return $btc->address;
	    }
	    else{
	      return $user_address->address;
	    }
	}
}
