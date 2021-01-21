<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Supportchat;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $guard)
    {
        View::composer('*', function($view) use($guard) {

            $adminTicketsCount = Supportchat::on('mysql2')->where('admin_status', 0)->count();
            $admin_mail = 'support@democonsummo.com';

            $view->with('adminTicketsCount', $adminTicketsCount);
            $view->with('adminmail', $admin_mail);
         
         });
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
