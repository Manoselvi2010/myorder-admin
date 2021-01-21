<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\CommissionRequest;
use App\Models\Commission;

class CommissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {    	
    	$commissions = Commission::index(); 
    	return view('commission_settings.index',[
                                    			'commissions' => $commissions, 
                                    		]);
    }
    public function edit($id)
    {
        $commission = Commission::edit(Crypt::decrypt($id));
        if($commission->type='coin'){
            $digit = 5;
        }
        else{
            $digit = 2;
        }
        return view('commission_settings.edit')->with('commission',$commission)->with('digit',$digit);
    }
    public function commissionUpdate(CommissionRequest $request)
    { 
        $commission = Commission::commissionUpdate($request);

        return back()->with('status','Commission Updated Successfully');
    }
}
