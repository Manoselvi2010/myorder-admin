<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminEthTransaction extends Model
{
   public static function deposit()
   {
   		$list  = AdminEthTransaction::where('type','received')->paginate(15);

   		return $list;
   }

   public static function withdraw()
   {
   		$list  = AdminEthTransaction::where('type','send')->paginate(15);

   		return $list;
   }
}
