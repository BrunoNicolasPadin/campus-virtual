<?php

namespace App\Http\Requests\Evaluaciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluacionArchivo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string',
            'visibilidad' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'Debe ingresar un titulo.',
            'titulo.string' => 'El titulo debe  ser una cadena de caracteres o numeros, no otra cosa.',
            'visibilidad.required' => 'Debe seleccionar una visibilidad.',
        ];
    }
}
