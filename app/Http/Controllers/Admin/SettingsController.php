<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Features;
use App\Models\Faq;
use App\Models\Benefits;
use App\Models\SocialMedia;
use App\Http\Requests\FaqRequest;
use App\Models\ErcTokens;
use App\Models\TwaOption;
use App\Models\UserpanelSettings;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class SettingsController extends Controller
{
    public function logo()
    {
        $terms = Setting::first();      
        return view('settings.logo', ['logo' => $terms]);
    }
    public function updateLogo(Request $request)
    {
        if(Input::hasFile('logo'))
        { 
            $url = \Config::get('app.url'); 
            $dir = 'logo/';
            $path = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;
            $fornt = Input::File('logo');
            $fornt->move($path, $fornt->getClientOriginalName());
            $front_img = $path.'/'.$fornt->getClientOriginalName();
            $logo = $url.'/'.$path.'/'.$fornt->getClientOriginalName();
        }else{
            $logo = $request->old_logo;
        }
        if(Input::hasFile('favicon'))
        { 
            $url = \Config::get('app.url');
            $dir = 'logo/';
            $path = 'storage' . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR.'public'. DIRECTORY_SEPARATOR. $dir;
            $fornt = Input::File('favicon');
            $fornt->move($path, $fornt->getClientOriginalName());
            $front_img = $path.'/'.$fornt->getClientOriginalName();
            $favicon = $url.'/'.$path.'/'.$fornt->getClientOriginalName();
        }else{
            $favicon = $request->old_favicon;
        }
        $team = Setting::first();
        $team->logo = $logo;
        $team->favicon = $favicon;
        $team->save();
        return redirect('admin/logo')->with('status','Updated Successfully');
    }
    public function tc()
    {
    	$terms = CMS::index();
    	return view('settings.tc', ['terms' => $terms]);
    }
    public function update_terms(Request $request)
    {
    	$update = CMS::updateTerms($request);    	
    	return back()->with('status',$update);
    }
    public function privacy()
    {
        $terms = CMS::index();
        return view('settings.privacy', ['privacy' => $terms]);
    }
    public function updatePrivacy(Request $request)
    {
    	$update = CMS::updatePrivacy($request);
    	return back()->with('status',$update);
    }
    public function aboutus()
    {
        $aboutus = CMS::index();
        return view('settings.aboutus', ['aboutus' => $aboutus]);
    }
    public function updateAbout(Request $request)
    {
    	$update = CMS::updateAbout($request);
    	return back()->with('status',$update);        
    }
    public function features()
    {
        $features = Features::on('mysql2')->get();
        return view('settings.feature.features')->with('features',$features);
    }
    public function benefits()
    {
        $features = Benefits::on('mysql2')->get();
        return view('settings.benefits.benefits')->with('features',$features);
    }
    public function benefits_settings(Request $request)
    { 
        $features = Benefits::updateBenefits($request);
        return back()->with('status',$features);
    }
    public function features_settings(Request $request)
    {
        $features = Features::updateFeatures($request);
        return back()->with('status',$features);
    }
    public function faq()
    { 
        $faq = Faq::on('mysql2')->get();
        return view('settings.faq')->with('faq',$faq);
    }
    public function faq_add()
    {
        return view('settings.faq_add');
    }
     public function faq_save(FaqRequest $request)
    { 
    	$faq = Faq::saveFaq($request);
        return redirect('admin/faq')->with('success','Added Successfully');;
    }
    public function faq_edit($id)
    {
        $faq = Faq::edit($id);
        return view('settings.faq_edit')->with('faq',$faq);
    }
    public function faq_update(Request $request)
    { 
    	$faq = Faq::faqUpdate($request);
        return redirect('admin/faq')->with('success',$faq);
    }
    public function socialMedia()
    {
        $socialMedia = SocialMedia::index();     
        return view('settings.social_media')->with('link',$socialMedia);
    }
    public function saveSocialMedia(Request $request)
    {
        $socialMedia = SocialMedia::saveSocialMedia($request);
        return back()->with('success', 'Social Media Setting Updated Successfully!');
    }   
    public function userpanelSettings()
    {
        $settings = UserpanelSettings::index();
        $fwofa_option = TwaOption::enable_list();
        return view('settings.userpanel_settings')->with('settings',$settings)->with('two_options',$fwofa_option);
    }
    public function saveUserpanelSettings(Request $request)
    {
        $socialMedia = UserpanelSettings::saveUserpanel($request);
        return back()->with('success', 'Updated Successfully');
    }
    public function token()
    {
        $token = ErcTokens::list();
        return view('settings.token')->with('token',$token);
    }
    public function addToken()
    { 
        return view('settings.add_token');
    }
    public function saveToken(Request $request)
    { 
        $save = ErcTokens::add($request);
        return back()->with('success','Added Successfully');
    }
    public function editToken($id)
    {
        $view = ErcTokens::view($id);
        return view('settings.view_token')->with('details',$view);
    }
    public function updateToken(Request $request)
    {
        $update = ErcTokens::updated($request);
        return back()->with('success','Updated Successfully');
    }
    public function twoFA()
    {        
        $token = TwaOption::list();
        return view('settings.2fa_option.twofa')->with('token',$token);
    }
    public function addtwoFA()
    { 
        return view('settings.2fa_option.add_twofa');
    }
    public function savetwofa(Request $request)
    { 
        $save = TwaOption::add($request);
        return back()->with('success','Added Successfully');
    }
    public function edittwofa($id)
    {
        $view = TwaOption::view($id);
        return view('settings.2fa_option.edit_twofa')->with('details',$view);
    }
    public function updateTwofa(Request $request)
    {
        $update = TwaOption::updated($request);
        return back()->with('success','Updated Successfully');
    }
}