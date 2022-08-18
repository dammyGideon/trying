<?php

namespace App\Http\Requests\Children;

use Illuminate\Foundation\Http\FormRequest;

class ChildrenCreationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            //
            'child_name'=>[
              'required',
                'string'
            ],
            'child_allergies'=>[
                'required',
                'string'
            ],
            'child_photo'=>[
                'required',
                'mimes:jpeg,png,jpg,gif'
            ],
        ];
    }
}
