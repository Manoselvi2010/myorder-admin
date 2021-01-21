<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminBtcTransaction extends Model
{
   public static function deposit()
   {
   		$list  = AdminBtcTransaction::where('type','received')->paginate(15);

   		return $list;
   }

   public static function withdraw()
   {
   		$list  = AdminBtcTransaction::where('type','send')->paginate(15);

   		return $list;
   }
}
