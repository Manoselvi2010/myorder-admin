<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;

use App\Models\AdminBtcAddress;
use App\Models\AdminBtcTransaction;
use App\Models\AdminEthAddress;
use App\Models\AdminEthTransaction;
use App\Models\AdminJadaxAddress;

use App\Models\UserBtcAddress;
use App\Models\UserEthAddress;
use App\Models\UserLtcAddress;
use App\Models\UserXrpAddress;
use App\Models\UserWallet;
use App\Models\User;

use App\Models\UserBtcTransaction;
use App\Models\UserEthTransaction;
use App\Models\UserJadaxTransaction;

use App\Traits\Bitcoin;
use App\Traits\Ethereum;
use App\Traits\AdminTokenEth;
use App\Traits\Blastcoin;
use App\Traits\AddressCreation;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail; 
use Illuminate\Notifications\Notifiable;

use Denpa\Bitcoin\Client as BitcoinClient;

use Denpa\Bitcoin\Client as Blastxcore;



class CronController extends Controller
{
// use Bitcoin, Ethereum, AdminTokenEth, Blastcoin;
	use AddressCreation;

	public function testmail($value='')
	{
		try {
			Mail::to('redme@mailinator.com')->send(new TestMail());
		} catch (Exception $e){
			dd($e);
		}		
	}

	public function blastcoin()
	{
		$data = $this->createaddress_blast();

		dd($data);


// // this is the default file name from the package

//      // kept here to avoid confusion over the file name require 'utils.php'; 
//      // server settings

//       $host = 'betty.userland.com';
//       $port = 80;
//       $uri = '/RPC2';

//       // request settings 
//       // pass in a number from 1-50; get the nth state in alphabetical order 
//       // 1 is Alabama, 50 is Wyoming 

//       $method = 'examples.getStateName';
//       $args = array(32);  // data to be passed 


//        // make associative array out of these variables 

//        $request = compact('host', 'port', 'uri', 'method', 'args'); 

//        // this function makes the XML-RPC request

//         $result = xu_rpc_http_concise($request); 

//         dd($result);

//         print "I love $result!\n"; 


		$bitcoind = new Blastxcore([
'scheme'        => 'http',                 // optional, default http
'host'          => 'localhost',            // optional, default localhost
'port'          => 18332,                   // optional, default 8332
'user'          => 'bitcoin',              // required
'password'      => 'local321',          // required
'ca'            => '/etc/ssl/ca-cert.pem',  // optional, for use with https scheme
'preserve_case' => false,                  // optional, send method names as defined instead of lowercasing them
]);

		dd($bitcoind);

		$masternode = new Blastxcore("blastxuser","dasffds8JUDYMqtekfE8PHvE6Yq3Gf4uNJjXp2");

		$result = $this->createaddress_blast();

		dd($result);		

		$bitcoind = new BitcoinClient('http://bitcoin:local321@localhost:18332/');

		dd($bitcoin);
	}


	public function blastcurl($value='')
	{


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://curl/%20-X%20POST%20http://62.171.168.72:38157/json_rpc%20-d%20%27%7B%22jsonrpc%22:%222.0%22,%22id%22:%220%22,%22method%22:%22get_quorum_state%22,%20%22params%22:%20%7B%22height%22:%20200%7D%7D%27%20-H%20%27Content-Type:%20application/json%27",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"postman-token: 968902d8-2d3a-429c-b4d1-2a71e213a857"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
	}



	public function AddressGenerate()
	{
		// $btc_count = UserBtcAddress::count();
		$eth_count = UserEthAddress::count();
		// $ltc_count = UserLtcAddress::count();
		// $xrp_count = UserXrpAddress::count();
		$eth_count = 1;
		$end = $eth_count+50;

		for ($i=$eth_count; $i < $end; $i++) { 
			$this->userAddressCreation($i);
		}

	}


}