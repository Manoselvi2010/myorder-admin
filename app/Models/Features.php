<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    public static function updateFeatures($request)
    {
    	for($i=1;$i<=sizeof($request->heading);$i++)
        {   
            $features = Features::on('mysql2')->where('id',$i)->first();
            $features->title = $request->heading[$i-1];
            $features->description = $request->description[$i-1];
            $features->save(); 
        }

        return $message = "Updated Successfully!";
    }
}
