<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'oldpassword'     => 'required',
            'newpassword'     => 'required|min:8|max:16',
            'confirmpassword' => 'required|same:newpassword',
             
        ];
    }
    

    public function message()
    {
        return [
            'oldpassword.required' => 'Current Password is required',
            'newpassword.required' => 'New Password is required',
            'confirmpassword.required' => 'Confirm New Password is required',
            'confirmpassword.same' => 'Wrong confirm password',
            
        ];
    }
}
