<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

                'nombre' => 'required|max:50',
                'apellidoP' => 'required|max:50',
                'apellidoM' => 'required|max:50',
                'email' => 'required|max:50',
                'password' => 'required|max:50',

            //
        ];
    }
}
