<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\AdminBtcTransactions::class,
        Commands\AdminEthTransactions::class,
        Commands\AdminJadaxTransactions::class,
        Commands\SendBtcToAdmin::class,
        Commands\SendEthToAdmin::class,
        Commands\SendBpcToAdmin::class,
        Commands\SendAdminToRemainingFee::class,
        Commands\UserAddressGeneration::class,
        Commands\UserBlastTransaction::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:admin_btc_transaction')->everyFiveMinutes();
        $schedule->command('command:admin_eth_transaction')->everyFiveMinutes();
        $schedule->command('command:admin_linear_transaction')->everyFiveMinutes();
        $schedule->command('command:send_btc')->everyFiveMinutes();
        $schedule->command('command:send_eth')->everyFiveMinutes();
        $schedule->command('command:send_jadax')->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
