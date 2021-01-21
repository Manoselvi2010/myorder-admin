<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $connection = 'mysql2';
    public $fillable = [
    						'site_status',    					
    						'description'    					
    					];
}
