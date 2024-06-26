<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Session;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       $userData = Session::get('userData');

        if(!empty($userData)) {
            return false;
        }

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
            'username'      =>  'required',
            'password'      =>  'required'
        ];
    }
}
