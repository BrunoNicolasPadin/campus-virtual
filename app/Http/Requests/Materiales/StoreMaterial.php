<?php

namespace App\Http\Requests\Materiales;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterial extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'archivo' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Debe ingresar un nombre.',
            'archivo.required' => 'Debe ingresar un archivo.',
        ];
    }
}
