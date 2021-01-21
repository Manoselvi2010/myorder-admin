<?php
namespace App\Traits;

trait Ethereum 
{	
	// create address
	public function eth_user_address_create(){
		$url = "https://api.blockcypher.com/v1/eth/main/addrs";
		$result = $this->cUrl($url);
		if($result)
		{
			return $result;
		}
	}
	
	public function cUrl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		if (curl_errno($ch)) {
			$result = 'Error:' . curl_error($ch);
		} else {
			$result = curl_exec($ch);
		}
		curl_close($ch);
		return json_decode($result, true);
	}

	public function cUrls($url, $postfilds=null)
	{
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
	
	public function exec_cUrls($url, $postfilds=null)
	{
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
	
	public function getEthBalance($address)
	{
		$url = "https://api.etherscan.io/api?module=account&action=balance&address=".$address;
		$balance = $this->cUrl($url);
		return $balance;
	}
	
	function weitoeth($amount){
		return $amount / 1000000000000000000;
	}

	function weitolinear($amount){
		return $amount / 100000000;
	}
	
	public function getEthTransaction($address)
	{
		$url = "http://api.etherscan.io/api?module=account&action=txlist&address=".$address."&startblock=0&endblock=99999999&sort=asc";
	    $balance = $this->cUrls($url);
	    return $balance;
	}

	public function getLinearTransaction($address)
	{
		 $url = "https://api.etherscan.io/api?module=account&action=tokentx&contractaddress=0xA0a19052aA80d7Fc258d24701b8F3c37dE70B925&address=".$address."&startblock=0&endblock=99999999&sort=asc&apikey=KSHMGIHSNC9GDF1IV1T3ZHDD473X3D5FG3";
		
	    $balance = $this->cUrls($url);
	    return $balance;
	}
	
	
	public function getMonBalance($address)
	{
		$url = "https://api.tokenbalance.com/balance/0x4dfc4a641bcd37a97527c86ffcad43f6000de1a3/".$address;
		$balance = $this->exec_cUrls($url);
		return $balance;
	}
	
	public function getMonTransaction($address)
	{
		$url = "https://api.etherscan.io/api?module=account&action=tokentx&contractaddress=0x4dfc4a641bcd37a97527c86ffcad43f6000de1a3&address=".$address."&page=1&offset=100&sort=asc&apikey=YourApiKeyToken";
	    $balance = $this->exec_cUrls($url);
	    return $balance;
	}
	
	public function ethSendTransaction($fromaddress, $toaddress, $eth_amount, $pvk)
	{
	    $ch = curl_init();
		$params = array(
			"method" => "create_rawtx",
			"formaddr" => $fromaddress,
			"pvk" => $pvk,
			"toddr" => $toaddress,
			"amount" => $eth_amount,
			"url" => "https://mainnet.infura.io/v3/b7b26b74451849d8808d4dd903fb31f2"
		);

		curl_setopt($ch, CURLOPT_URL, "http://128.199.211.12:8545");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
		$headers = array();
		$headers[] = "Content-Type : application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return json_decode($result);
	}

	public function jadaxSendTransaction($fromaddress, $toaddress, $eth_amount, $pvk)
	{
		$ch = curl_init();
		$params = array(
			"method" => "create_rawjadax",
			"formaddr" => $fromaddress,
			"pvk" => $pvk,
			"toddr" => $toaddress,
			"amount" => $eth_amount,
			"url" => "https://mainnet.infura.io/v3/b7b26b74451849d8808d4dd903fb31f2"
			);
		curl_setopt($ch, CURLOPT_URL, "http://128.199.211.12:8545");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
		$headers = array();
		$headers[] = "Content-Type : application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return json_decode($result);
	}

	public function usdtSendTransaction($fromaddress, $toaddress, $eth_amount, $pvk)
	{
		$ch = curl_init();
		$params = array(
			"method" => "create_rawjadax",
			"formaddr" => $fromaddress,
			"pvk" => $pvk,
			"toddr" => $toaddress,
			"amount" => $eth_amount,
			"url" => "https://mainnet.infura.io/v3/b7b26b74451849d8808d4dd903fb31f2"
			);
		curl_setopt($ch, CURLOPT_URL, "http://128.199.211.12:8545");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
		$headers = array();
		$headers[] = "Content-Type : application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return json_decode($result);
	}
}
?>