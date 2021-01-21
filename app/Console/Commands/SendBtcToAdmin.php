<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserBtcAddress;
use App\Models\UserBtcTransactions;
use App\Models\UserWallet;
use App\Traits\Bitcoin;

class SendBtcToAdmin extends Command
{
    use Bitcoin;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_btc';

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
        $btc = UserBtcTransactions::on('mysql2')->where('status','1')->where('type','received')->get();
        $this->btcCron($btc->id);
    }

    public function btcCron($id)
    {
        $user = UserBtcTransactions::on('mysql2')->where('status','1')->where('type','received')->where('id',$id)->first(); 

        if(count($user)>0)
        {
            $admin = AdminBtcAddress::first();
            $amount = $user->amount;
            $from_address = $user->recipient;
            $to_address = $admin->address;
            $fee = 0.00002;  
            $final_amount  = $amount - $fee ;
            $user_details = UserBtcAddress::where('user_id',$user->user_id)->first();
            $credential = explode(',',$user_details->narcanru);
            $pvtk = Crypt::decryptString($credential[2]);

            $send_to_admin = $this->send($to_address, $final_amount, $from_address, $pvtk, $fee);

            if($send_to_admin)
            {
                
                $update = UserWallet::on('mysql2')->where('uid',$user->user_id)->where('currency','BTC')->first();  
                $update->site_balance = $update->site_balance + $final_amount;
                $update->balance = $update->balance + $final_amount;
                $update->save();
                
                $user->status = 2;
                $user->save();
            }
            else
            {
                echo "Transaction Falied";
            }
        }
        else
        {
            echo 'No Records Found';
        }
    }
}
