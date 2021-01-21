<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Traits\BtcClass;
use App\Traits\EthClass;

class UserAddressGeneration extends Command
{
    use BtcClass, EthClass;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:useraddress';

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
        $user_count = 1;
        $end = 2;

        for ($i= $user_count; $i < $end; $i++) { 
            $btcAddress = $this->btc_user_address_create($i);
            $ethAddress = $this->create_user_eth($i);
            
        }

        return 'adress created.';
    }
}
