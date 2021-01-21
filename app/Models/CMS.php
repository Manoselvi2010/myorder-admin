<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMS extends Model
{
    protected $table = 'cms';


    public static function index()
    {
        $terms = CMS::on('mysql2')->where('id', 1)->first();

        return $terms;
    }

    public static function updateTerms($request)
    {
    	$tc = $request->tc;
        if($tc !='')
        {
            $update = CMS::on('mysql2')->where('id', 1)->update(['tc' => $tc]);
            if($update)
            {
                $message = "Updated Successfully!";
            }
        }
        else
        {
            $message = "Fields Are Empty. Try Again!";
        }

        return $message;
    }

    public static function updatePrivacy($request)
    {
        $privacy_policy = $request->privacy;

        if($privacy_policy !='')
        {
            $update = CMS::on('mysql2')->where('id', 1)->update(['privacy_policy' => $privacy_policy]);

            if($update)
            {
                $message = "Updated Successfully!"; 
            }
        }
        else
        {
            $message = "Fields Are Empty. Try Again!";
        }

        return $message;
    }

    public static function updateAbout($request)
    {
    	$aboutus = $request->aboutus;

        if($aboutus !='')
        {
            $update = CMS::on('mysql2')->where('id', 1)->update(['aboutus' => $aboutus]);
            if($update)
            {
                $message = "Updated Successfully!";
            }
        }
        else
        {
            $message = "Fields Are Empty. Try Again!";
        }

        return $message;
    }


}
