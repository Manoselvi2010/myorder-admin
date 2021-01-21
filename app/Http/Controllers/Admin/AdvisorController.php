<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Advisor;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;


class AdvisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $faq = Advisor::on('mysql2')->paginate(15);
        return view('settings.advisor.advisor')->with('faq',$faq);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $faq = Advisor::find($id);

        return view('settings.advisor.editadvisor')->with('commission',$faq);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $commission = Advisor::on('mysql2')->where('id', $request->id)->first();

        if(Input::hasFile('blog_image')){ 

            $url = \Config::get('app.url'); 

            $dir = 'advisor/';
            $path = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;

            $fornt = Input::File('blog_image');
            $fornt->move($path, $fornt->getClientOriginalName());
            $front_img = $path.'/'.$fornt->getClientOriginalName();

            $front_img = $url.'/'.$path.'/'.$fornt->getClientOriginalName();
        }
    
        $commission->name       = $request->name;
        $commission->position = $request->position; 
        $commission->image       = $front_img;
        $commission->save();

        return redirect('admin/project_advisor')->with('status','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
