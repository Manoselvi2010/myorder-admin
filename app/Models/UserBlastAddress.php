<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBlastAddress extends Model
{

    public function blastdetails()
	{
	  return $this->belongsTo('App\User', 'user_id');
	}
}
