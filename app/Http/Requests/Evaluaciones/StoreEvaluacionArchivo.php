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
            'nombre.*' => 'required|string',
            'visibilidad.*' => 'required',
            'archivos.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.*.required' => 'Debe ingresar un nombre.',
            'nombre.string' => 'El nombre debe  ser una cadena de caracteres (letras, numeros o signos), no otra cosa.',
            'visibilidad.*.required' => 'Debe seleccionar una visibilidad.',
            'archivos.*.required' => 'Debe ingresar un archivo.',
        ];
    }
}
