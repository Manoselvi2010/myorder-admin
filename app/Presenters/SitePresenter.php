<?php
namespace App\Presenters;
use Laracasts\Presenter\Presenter;
use Illuminate\Support\Facades\Crypt;

class SitePresenter extends Presenter
{
    public function getRecipientName($val)
    {       

        return $val != "" ? mb_strimwidth( Crypt::decryptString($val), 0, 50, "...") : '-';
    }

    public function getSenderName($val)
    {       

        return $val != "" ? mb_strimwidth( Crypt::decryptString($val), 0, 50, "...") : '-';

    }

    public function getTransactionId($val)
    {       

        return $val != "" ? mb_strimwidth( $val, 0, 50, "...") : '-';
    }
   
}