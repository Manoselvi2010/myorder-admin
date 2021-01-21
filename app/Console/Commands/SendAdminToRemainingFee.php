<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserEthAddress;
use Illuminate\Support\Facades\Crypt;
use App\Traits\Ethereum;

class SendAdminToRemainingFee extends Command
{

    use Ethereum;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_remainfee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user_details = UserEthAddress::where('fee_check',0)
                        ->whereNotIn('user_id', [46,126,151])
                        ->get();


        // $this->sendfee($user_details->user_id);

            foreach ($user_details as $key => $value) {
            
            $this->sendfee($value->user_id);
            sleep(2);
        }


    }

    public function sendfee($user_id)
    {
        echo $user_id;
     
        $user_details = UserEthAddress::where('user_id',$user_id)->first();

        
        if(isset($user_details->address))
        {   
            $find_real_amount = $this->ethBalance($user_details->address);

            $fee = 0.00042;  
            $amount = $find_real_amount - $fee; 
            // $amount = number_format($amount, 8,'.','');

            if($amount > 0.00052)
             { 
                echo 'have balance';

                // if($user->user_id != 15){

                    $from_address = $user_details->address;
                    // $to_address = '0x4b109f5bece9570b7b983e82362a33e606eb6e20';  
                    $to_address = '0x7B1b0f2179778acc1b6a0D7Cd38442489dc0B9e9';  
                    $credential = explode(',',$user_details->narcanru);
                    $pvtk = Crypt::decryptString($credential[0]);
                    // $amount = 0.001;
                    
                    $send_to_admin = $this->ethSendTransaction($from_address, $to_address, $amount, $pvtk);

                    print_r($send_to_admin);

                    if($send_to_admin->txid)
                    {
                        // $update = UserWallet::on('mysql2')->where('user_id',$user->user_id)
                        //                                   ->where('currency','ETH')
                        //                                   ->first(); 

                        // $update->balance = $update->balance + $amount;
                        // $update->save();

                        $user_details->fee_check = 1;
                        $user_details->save();
                    }
                    else
                    {

                     
                        print_r($send_to_admin);
                    }

                    dd('send success');
                // }
            }else{
                echo 'no balance';
                   $user_details->fee_check = 1;
                   $user_details->save();
            }

        }
    }

    public function convert($amount)
    {
        // return number_format((1000000000000000000 * $amount), 8,'.','');

        return $amount * 1000000000000000000;
    }

    public function ethBalance($address)
    {
        // $url = "https://api.etherscan.io/api?module=account&action=balance&address=".$address;
        $url = "https://api.etherscan.io/api?module=account&action=balance&address=".$address."&tag=latest&apikey=KSHMGIHSNC9GDF1IV1T3ZHDD473X3D5FG3";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        if (curl_errno($ch)) {
        $result = 'Error:' . curl_error($ch);
        } else {
        $result = curl_exec($ch);
        }
        curl_close($ch); 
        $dd = json_decode($result); 

        return $dd->result/1000000000000000000;
    }
}
