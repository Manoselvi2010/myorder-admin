<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class MaintenanceController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();
        return view('under_maintenance.edit')->with('setting', $setting);
    }
    public function update(Request $request,$id = null)
    {
    	$data = $request->all();
    	$setting = Setting::updateOrCreate([
                                                'id' => $id,
                                            ],[
                                                'site_status' => $data['site_status'], 
												'description' => $data['description']
                                            ]);
        return redirect()->route('under_maintenance.edit')->with('success','updated successfully.');
    }
}
