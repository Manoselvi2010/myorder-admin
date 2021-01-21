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
	private function _call($params){
		$this->ch = curl_init();
		$this->params = $params;
		// curl_setopt($this->ch, CURLOPT_URL, "http://63.209.32.63:8085");
		curl_setopt($this->ch, CURLOPT_URL, "http://62.171.168.72:8085");
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
	

	public function getinfo()
	{
		require_once('easybitcoin.php');
		$masternode = new Blastxcore("blastxuser","dasffds8JUDYMqtekfE8PHvE6Yq3Gf4uNJjXp2");

		$result = $masternode->getinfo();

		print_r($result);

		// blastx-cli -rpcconnect=127.0.0.1
		 // -rpcpassword=dasffds8JUDYMqtekfE8PHvE6Yq3Gf4uNJjXp2 
		// -rpcuser=blastxuser getinfo
	}

}
