<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Requests\AdminRequest;

class AddTimelineRequest extends AdminRequest
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
            'name'          =>  'required',
            'description'   =>  'required',
            'date_start'    =>  'required',
            'date_end'      =>  'required',
            'id_event'      =>  'required'
        ];
    }
}
