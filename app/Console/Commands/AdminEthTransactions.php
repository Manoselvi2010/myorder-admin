<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdminEthAddress;
use App\Models\AdminEthTransaction;
use App\Traits\Ethereum;

class AdminEthTransactions extends Command
{
    use Ethereum;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:admin_eth_transaction';

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
        $admin_address = AdminEthAddress::first();
        $address = $admin_address->address; 
        $balance = $this->getEthTransaction($address);

        if($balance)
        {
            $count = count($balance['result']);
            if($count > 0)
            {
                $result_data = $balance['result'];
                for($i = 0; $i < $count; $i++)
                {
                    $data = $result_data[$i];
                    $tx_hash = $data['hash'];
                    $sender = $data['from'];
                    $receiver = $data['to'];
                    $total = $this->weitoeth($data['value']);
                    $confirmations = $this->weitoeth($data['confirmations']);

                    if($address == $sender)
                    {
                        $type = 'send';
                    }
                    else
                    {
                        $type = 'received'; 
                    }

                    $is_txn = AdminEthTransaction::where('txid', $tx_hash)->count();
                    if($is_txn == 0)
                    {   
                        $his = new AdminEthTransaction; 
                        $his->type = 'received';
                        $his->recipient = $receiver;
                        $his->sender = $sender;
                        $his->amount = $total; 
                        $his->txid = $tx_hash; 
                        $his->save();
                    }   
                }
            } 
        }
    }
}
