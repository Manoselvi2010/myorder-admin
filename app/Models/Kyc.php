<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserKyc;
use Illuminate\Support\Facades\Mail;
use App\Mail\KycEmail; 
use Illuminate\Notifications\Notifiable;

class Kyc extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'kyc';

    public static function index()
    {
    	$kyc = Kyc::on('mysql2')->orderBy('id','desc')->paginate(10);

    	return $kyc;
    }

   	public static function edit($id)
    {
    	$kyc = Kyc::on('mysql2')->where('id',$id)->first();

    	return $kyc;
    }

    public static function updateKyc($request)
    { 
        
        $kyc_id = $request->kyc_id; 
        $status = $request->status;
        $uid = $request->uid;
        
        if($status == 1){
            $kyc_verify = 1;

            $insert = new UserKyc;
            $insert->user_id = $uid;
            $insert->email = user($uid)->email ;
            $insert->save();

        } elseif($status == 3){
            $kyc_verify = 3; 
            
        } else {
           $kyc_verify = 2; 
        }

        if($kyc_verify!=3 && $status!=2)
        {
            $details = array(
                'status'=>$kyc_verify,  
                'user' => user($uid)->name 
                );

            Mail::to(user($uid)->email )->send(new KycEmail($details));
        } 

        Kyc::on('mysql2')->where('id', $kyc_id)->update(['status' => $status]);

        User::where('id', $uid)->update(['kyc_verify' => $kyc_verify]); 
        
        return true; 
    }

      public function kycdetails()
    {
      return $this->belongsTo('App\Models\User');
    }
}
