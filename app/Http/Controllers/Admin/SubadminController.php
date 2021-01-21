<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class SubadminController extends Controller
{
    public function index()
    {
        $subadmins = Admin::where('type', 'subadmin')->get();
    	return view('subadmins.index')->with('subadmins',$subadmins);
    }
    public function add()
    {
    	return view('subadmins.add');
    }
    public function store(Request $request)
    {
        $rules = [
                    'email' => 'required|string|email|max:255|unique:admins',
                ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) { 
            return back()->withInput()->withErrors($validator);
        }else{ 
        	$subadmin            = new Admin();
        	$subadmin->email     = $request->email;
        	$subadmin->password  = bcrypt($request->password);
            $subadmin->role      = implode(",",$request->access);
            $subadmin->type      = 'subadmin';
        	$subadmin->save();
            return redirect()->route('subadmins.index')->with('status','Added Successfully');
        }
    }
    public function edit($id)
    {
        $subadmin = Admin::find($id);
        return view('subadmins.edit')->with('subadmin',$subadmin);
    }
    public function update(Request $request)
    { 
        $data = $request->all();
        Admin::where('id',$data['user_id'])->update([
                                                    'role' => implode(",",$request->access),
                                                ]); 
        return redirect()->route('subadmins.index')->with('success','Update Successfully');
    }
    public function destroy($id)
    {
        Admin::where('id',$id)->delete();
        return back()->with('success','Deleted Successfully');
    }    
}