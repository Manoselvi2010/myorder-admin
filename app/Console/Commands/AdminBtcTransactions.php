<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdminBtcAddress;
use App\Models\AdminBtcTransaction;
use App\Traits\Bitcoin;

class AdminBtcTransactions extends Command
{
    use Bitcoin;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:admin_btc_transaction';

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
        $admin_address = AdminBtcAddress::first();
        $address = $admin_address->address;
        $get_transaction = $this->getTransactions($address);

        if($get_transaction && isset($get_transaction->txs) && count($get_transaction->txs) > 0){
            foreach($get_transaction->txs as $transaction){
                $tx_hash    = $transaction->txid;
                $sender     = $transaction->vin[0]->addr;
                $confirm    = $transaction->confirmations;
                $fees       = $transaction->fees;
                $time       = $transaction->time;
                foreach($transaction->vin as $vin){
                    if($vin->addr === $address){
                        break;
                    }
                }
                foreach ($transaction->vout as $vout) {
                    if(in_array($address , $vout->scriptPubKey->addresses)){
                        $receiver = $address;
                        $total = $vout->value;
                        break;
                    }
                }

                $type = "send";

                if(isset($receiver) && $receiver == $address)
                {
                    $type = "received";
                }
                if(isset($receiver) && $receiver!= $sender)
                {
                    
                    $is_txn = AdminBtcTransaction::where('txid', $tx_hash)->count();

                    if($is_txn == 0)
                    {
                        $btctransaction = new AdminBtcTransaction;
                        $btctransaction->type = 'received';
                        $btctransaction->recipient = $receiver;
                        $btctransaction->sender = $sender;
                        $btctransaction->amount = $total;
                        $btctransaction->txid = $tx_hash;
                        $btctransaction->save();
                    }
                }
            } 
        } 
    }
}
