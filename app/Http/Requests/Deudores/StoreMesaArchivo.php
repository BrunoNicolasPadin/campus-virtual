<?php

namespace App\Http\Requests\Deudores;

use Illuminate\Foundation\Http\FormRequest;

class StoreMesaArchivo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'visibilidad.*' => 'required',
            'archivos.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'visibilidad.*.required' => 'Debe seleccionar una visibilidad.',
            'archivos.*.required' => 'Debe ingresar un archivo.',
        ];
    }
}
