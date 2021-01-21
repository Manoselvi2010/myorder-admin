<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdminEthAddress;
use App\Models\AdminLinearTransaction;
use App\Traits\Ethereum; 
use App\Models\UserEthAddress;

class AdminJadaxTransactions extends Command
{

     use Ethereum;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:admin_linear_transaction';

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
        $admin = AdminEthAddress::first();

        if(isset($admin->address))
        {
            $address = $admin->address; 

            $balance = $this->getLinearTransaction($address);

            if(is_array($balance['result']))
            {
                $count = count($balance['result']);
                if($count > 0)
                {
                    $result_data = $balance['result'];
                    for($i = 0; $i < $count; $i++)
                    {
                        $data = $result_data[$i];

                        print_r($data);

                        $tx_hash = $data['hash'];
                        $sender = $data['from'];
                        $receiver = $data['to'];
                        $total = $this->weitolinear($data['value']);
                        $confirmations = $this->weitoeth($data['confirmations']);

                        if($address == $sender)
                        {
                            $type = 'send';
                        }
                        else
                        {
                           echo 'sender = '.$sender;
                             $user_details = UserEthAddress::where('address',$sender)->first();
                            if(is_object($user_details)){
                                echo 'herer';
                                $is_txn = AdminLinearTransaction::where('txid', $tx_hash)->count();
                                if($is_txn == 0)
                                {   
                                    $his = new AdminLinearTransaction; 
                                    $his->user_id = $user_details->user_id;
                                    $his->type = 'received';
                                    $his->recipient = $receiver;
                                    $his->sender = $sender;
                                    $his->amount = $total; 
                                    $his->fees = 0;
                                    $his->total_amount = 0;
                                    $his->status = 1;
                                    $his->txid = $tx_hash; 
                                    $his->save(); 
                                
                                }
                            }
                        }  
                    }
                } 
            }
        }


    }
}
