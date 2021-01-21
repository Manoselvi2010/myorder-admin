<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserEthTransaction;
use App\Models\UserEthAddress;
use App\Models\UserWallet;
use App\Models\AdminEthAddress;
use App\Traits\Ethereum;
use Illuminate\Support\Facades\Crypt;

class SendEthToAdmin extends Command
{
    use Ethereum;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_eth';

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
        $eth = UserEthTransaction::on('mysql2')->where('status','1')->where('type','received')->get();
        foreach ($eth as $key => $value) {
            $this->ethCron($value->id);
        }
        
    }

    public function ethCron($id)
    {
        echo $id;
        $user = UserEthTransaction::on('mysql2')->where('type','received')->where('status','1')->where('id',$id)->first();

        $admin = AdminEthAddress::first();

        $user_details = UserEthAddress::where('user_id',$user->user_id)->first();
        
        if(isset($user_details->address))
        {   
            $fee = 0.00042;  
            $amount = $user->amount - $fee; 
            if($amount > 0.00052)
             { 
                // if($user->user_id != 15){

                    $from_address = $user->recipient;
                    $to_address = $admin->address;  
                    $credential = explode(',',$user_details->narcanru);
                    $pvtk = Crypt::decryptString($credential[0]);
                    $amount = $this->convert($amount);
                    
                    $send_to_admin = $this->ethSendTransaction($from_address, $to_address, $amount, $pvtk);

                    if($send_to_admin->txid)
                    {
                        $update = UserWallet::on('mysql2')->where('user_id',$user->user_id)
                                                          ->where('currency','ETH')
                                                          ->first(); 

                        $update->balance = $update->balance + $amount;
                        $update->save();

                        $user->status = 2;
                        $user->save();
                    }
                    else
                    {
                        print_r($send_to_admin);
                    }
                // }
            }

        }
    }

    public function convert($amount)
    {
        // return number_format((1000000000000000000 * $amount), 8,'.','');

        return $amount * 1000000000000000000;
    }
}
