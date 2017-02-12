<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Requests\AdminRequest;

class AddPartnerAccountRequest extends AdminRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'                  =>  'required|unique:users,username',
            'password'                  =>  'required|confirmed',
            'password_confirmation'     =>  'required',
            'full_name'                 =>  'required',
            'email'                     =>  'required|email',
            'site_url'                  =>  'required',
            'avatar'                    =>  'required',
            'package_id'                =>  'required|exists:packages,id'
        ];
    }
}
