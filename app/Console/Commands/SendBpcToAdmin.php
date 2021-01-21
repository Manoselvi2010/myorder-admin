<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserBpcTransaction;
use App\Models\UserEthAddress;
use App\Traits\Ethereum;
use App\Models\UserWallet;
use App\Models\AdminEthAddress;
use App\Models\AdminTokenEthAddress;
use Illuminate\Support\Facades\Crypt;

class SendBpcToAdmin extends Command
{
    use Ethereum;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_bpc';

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
        $jadax = UserBpcTransaction::on('mysql2')->where('status','1')->where('type','received')->orderBy('id','DESC')->first();

          // $this->jedaxCrons($jadax->id);
          $this->bpcCrons(115);

        // foreach ($jadax as $key => $value) {
            
        //     $this->jedaxCrons($value->id);
        //     sleep(2);
        // }
        
    }

    public function bpcCrons($id)
    {
        echo $id."\n";
        $move_amount = UserBpcTransaction::on('mysql2')->where('id',$id)->where('status','1')->first();

        if($move_amount && $move_amount->count() > 0)
        {
            $user_id = $move_amount->user_id;
            
            $admin = AdminEthAddress::first();

            $user_details = UserEthAddress::where('user_id',$user_id)->first();

            if(isset($user_details->address))
            {
                $get_user_address = $user_details->address;

                $find_real_amount = $this->ethBalance($get_user_address);

                if($find_real_amount >= 0.001)
                {
                    echo "have eth balance \n";
                    if(is_object($user_details))
                    {   
                        $fee = 0.00080764155;
                        $amount = $move_amount->amount;
                        $total_send_amount = $amount;

                        $from_address = $get_user_address;
                        $credential = explode(',',$user_details->narcanru);
                        $pvtk = Crypt::decryptString($credential[0]);
                        $to_address = $admin->address;

                        if($to_address !='' && $to_address !=NULL)
                        {   
                            $contract = "0xed8000596c702a75d5d566ccc2cbacd27224041c";
                            $send_amount = $this->convert($total_send_amount);
                            $send = $this->jadaxSendTransaction($from_address, $to_address, $send_amount, $pvtk);
                            print_r($send);
                            if(isset($send) && $send->txid!='')
                            {
                                // $update = UserWallet::on('mysql2')->where('user_id',$user_id)->where('currency','LINEAR')->first();
                                // $update->balance = $update->balance + $amount;
                                // $update->save();

                                $move_amount->status = 2;
                                $move_amount->save();
                            }
                            else
                            {
                                print_r($send);
                            }
                        }
                    }

                }
                else
                {
                    echo "no eth balance \n";

                   if($move_amount->eth_send == 0){
                        echo "eth not send \n";
                        $send_from_admin = $this->sendFromAdminUser($get_user_address);

                        $move_amount->eth_send = '1';
                        $move_amount->save();

                   }else{
                    echo "already eth send \n";
                   }                    
                    
                }

            }
        } 
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

        print_r($dd);
        return $dd->result/1000000000000000000;
    }

    public function convert($amount)
    {
        return number_format((100000000 * $amount), 8,'.','');
    }

    public function sendFromAdminUser($toaddress)
    {
        echo 'admin send eth to user';
        // $user_details = UserEthAddress::where('user_id',15)->first();
        $user_details = AdminTokenEthAddress::first();

        $fee = 0.00042;  
        $amount = 0.00142 - $fee; 
        $from_address = $user_details->address;
        $to_address = $toaddress;  
        // $to_address = '0x7B1b0f2179778acc1b6a0D7Cd38442489dc0B9e9';  

        $credential = explode(',',$user_details->narcanru);
        $pvtk = Crypt::decryptString($credential[0]);
        $send_to_admin = $this->ethSendTransaction($from_address, $to_address, $amount, $pvtk);

        return $send_to_admin;
    }
}
