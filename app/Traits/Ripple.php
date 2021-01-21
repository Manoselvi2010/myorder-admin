<?php
namespace App\Traits;

trait Ripple 
{	
	private $ch1;
	private $params1;
	private $result1;
	private function _callxrp($params1){
		$this->ch1 = curl_init();
		$this->params1 = $params1;
		// curl_setopt($this->ch1, CURLOPT_URL, "http://45.32.105.246:8085");
		curl_setopt($this->ch1, CURLOPT_URL, "https://45.32.235.240:8086");
		curl_setopt($this->ch1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch1, CURLOPT_POST, 1);
		curl_setopt($this->ch1, CURLOPT_POSTFIELDS, json_encode($this->params1));
		$headers = array();
		$headers[] = "Content-Type : application/json";
		curl_setopt($this->ch1, CURLOPT_HTTPHEADER, $headers);
		$this->result = curl_exec($this->ch1);
		if (curl_errno($this->ch1)) {
			echo 'Error:' . curl_error($this->ch1);
		}
		curl_close($this->ch1);
		return json_decode($this->result1);
	}
	
	
	// create address
	public function createaddress_xrp(){
		$params = array("method" => "create_address");
		if(!empty($params)){
			return $this->_callxrp($params);
		}
	}
	
	// send bitcoin
	public function sendxrp($to, $amount, $from=null,$pvtkey, $fee=null){		
		$params = array(
			"method" => "create_rawtx",
			"fromaddr" => $from,
			"privatekey" => $pvtkey,
			"toaddr" => $to,
			"amount" => $amount
		);
		if(!empty($params)){
			$rawtx = $this->_callxrp($params);				
		}
	}
	
	public function getBalancexrp($address){
		if(!empty($address)){
			$url = $this->url."addr/$address/balance";
			$balance = $this->cUrl1($url);
			return $this->sathositobtc($balance);
		}else{
			return 0;
		}
	}
	
}
?>