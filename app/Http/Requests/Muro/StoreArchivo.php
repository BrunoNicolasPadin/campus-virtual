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
            'archivos.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'archivos.*.required' => 'Debe ingresar un archivo.',
        ];
    }
}
