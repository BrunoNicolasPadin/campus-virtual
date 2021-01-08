<?php

namespace App\Http\Requests\Evaluaciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluacionArchivo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string',
            'archivo' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'Debe ingresar un titulo.',
            'titulo.string' => 'El titulo debe  ser una cadena de caracteres o numeros, no otra cosa.',
            'archivo.required' => 'Debe ingresar un archivo.',
        ];
    }
}
