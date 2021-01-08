<?php

namespace App\Http\Requests\Muro;

use Illuminate\Foundation\Http\FormRequest;

class StoreArchivo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'archivo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'archivo.required' => 'Debe ingresar un archivo.',
        ];
    }
}
