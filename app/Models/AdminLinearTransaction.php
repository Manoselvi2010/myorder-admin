<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLinearTransaction extends Model
{
    public static function deposit()
   {
   		$list  = AdminLinearTransaction::where('type','received')->paginate(15);

   		return $list;
   }

   public static function withdraw()
   {
   		$list  = AdminLinearTransaction::where('type','send')->paginate(15);

   		return $list;
   }
}
