<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\Blastcoin;
use App\Models\UserBlastAddress;
use App\Models\UserBlastTransactions;
use App\Models\UserWallet;

class UserBlastTransaction extends Command
{
    use Blastcoin;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blast:transaction';

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
        $his = $this->history_blast();

        if(isset($his))
        {   

            if($his && isset($his->transaction)){ 

                foreach($his->transaction as $transaction){

                    if($transaction->category == 'receive'){

                      $user_address = UserBlastAddress::where('address',$transaction->address)->first();

                      if(is_object($user_address)){

                          $is_txn = UserBlastTransactions::where('txid', $transaction->txid)->count();

                            if($is_txn == 0)
                            {
                                $btctransaction = new UserBlastTransactions;
                                $btctransaction->user_id = $user_address->user_id;
                                $btctransaction->type = 'received';
                                $btctransaction->recipient = $transaction->address;
                                $btctransaction->sender = '';
                                $btctransaction->amount = $transaction->amount;
                                $btctransaction->fees = 0;
                                $btctransaction->total_amount = 0;
                                $btctransaction->status = 1;
                                $btctransaction->txid = $transaction->txid;
                                $btctransaction->save();

                                $user_wallet = UserWallet::where('user_id',$user_address->user_id)->where('currency','BLAST')->first();

                                if(is_object($user_wallet)){

                                    $user_wallet->balance = $user_wallet->balance+$transaction->amount; 
                                    $user_wallet->save(); 

                                }else{
                                    UserWallet::create([
                                        'escrow_balance' => 0,
                                        'balance' => $transaction->amount,
                                        'user_id' => $user_address->user_id,
                                        'currency' => 'BLAST',
                                    ]);
                                }
                            }

                      }else{
                      
                      }
                } 
            }
            } 
        }

    }
}
