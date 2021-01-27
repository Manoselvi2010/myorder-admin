<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\UserMail;
use Mail;

class MailController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        return view('user.details.mail')->with('user',$user);
    }
    public function single_mail_submit(Request $request)
    {
        $data = $request->all(); 
        $user = User::find($data['user_id']);
        Mail::to($user->email)->send(new UserMail($data));
        if (Mail::failures()) {
            // return response showing failed emails
            return(Mail::failures());
        }  
        return redirect()->route('users.index')->with('success','Mail Sent Successfully');
    }
}
