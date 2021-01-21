<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Admin;
use Session;
class SecuritysettingController extends Controller
{
    public function edit()
    {
        $admin = Admin::find(Session::get('adminId'));
    	return view('security_settings.edit')->with('admin', $admin);
    }
    public function change_email(Request $request)
    {
    	$rules = [
                    'email' => 'required|string|email|max:255|unique:admins',
                ];        
        $messages = ['email.required' => 'Email field is required.'];        
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) { 
        	return back()->withInput()->withErrors($validator);
        }else{ 
	        $adminDetail = Admin::where('id', Session::get('adminId'))->first();
	        $adminDetail->email = $request->email;
	        if ($adminDetail->save())
	        {
	            return back()->with('success','Email updated successfully.');
	        }
	        else
	        {
	            return back()->with('error', 'Email updated failed!!!.');
	        }        
	    }
    }
    public function change_password(ChangePasswordRequest $request)
    {   
    	$data = $request->all();
        $admin = Admin::find($data['user_id']);
    	// printf(json_encode($admin));exit;
        $hashedPassword = $admin->password;         
        if (\Hash::check($request->oldpassword, $hashedPassword)) {
            $admin->password = \Hash::make($request->newpassword);
            $admin->save();
           return back()->with('success', 'Password changed successfully');      
        } 
        else
        {
           return back()->with('error', 'Given Old Password was wrong!!!');          
        }       
    }
    // public function updateUsername(Request $request)
    // {
    //     $update = Admin::updateUsername($request);
    //     return back()->with('status',$update);
    // }
    // public function changepassword(Request $request)
    // {
    //     $update = Admin::changepassword($request);
    //     return back()->with('status',$update);
    // }
}
