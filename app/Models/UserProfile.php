<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
     protected $table = 'userprofiles';

     public static function find($id)
     {
     	$user = UserProfile::on('mysql2')->where('user_id', '=', $id)->first();

        return $user;
     }
}