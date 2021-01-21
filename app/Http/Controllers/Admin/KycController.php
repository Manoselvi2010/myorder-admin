<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kyc;
use Illuminate\Support\Facades\Crypt;
use App\Traits\AddressCreation;

class KycController extends Controller
{
    use AddressCreation;

	public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {    	
    	$kyc = Kyc::index();
    	return view('user.kyc',[
    			'kyc' => $kyc
    		]);
    }

    public function kycview($id)
    {
        $kyc = Kyc::edit(Crypt::decrypt($id));

        $url =  config('app.conflnk');

        return view('user.kyc_edit',[
                'kyc' => $kyc,'url' => $url
            ]);
    }

    public function kycUpdate(Request $request)
    {
        if($request->status == 1)
        {
            $userAddressCreation = $this->userAddressCreation($request->uid);

            if($userAddressCreation == 1)
            {
                 $kyc = Kyc::updateKyc($request);
                 
                 return back()->with('status','Kyc Updated Successfully');
            }
            else
            {
                 return back()->with('fail','Kyc Updated Failed');
            }
        } 
        else
        {
            $kyc = Kyc::updateKyc($request);
            return back()->with('status','Kyc Updated Successfully');
        } 
        return redirect('/kyc')->with('status','Kyc Updated Successfully');
    }
}
