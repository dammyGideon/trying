<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class parent_regRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email'=>[
                'required',
                'string',
                'email',
                'unique:users'
            ],
            'password'=>[
                'required'
            ],
            'parent_name'=>[
                'required',
                'string'
            ],
            'parent_number'=>[
              'required',
                'string'
            ],
            'parent_dob'=>[
              'required',
                'string'
            ],
            'parent_photo'=>[
                'mimes:jpeg,png,jpg,gif'
            ]
        ];
    }
}
