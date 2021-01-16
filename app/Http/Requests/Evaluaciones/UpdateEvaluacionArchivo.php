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
            'nombre' => 'required|string',
            'visibilidad' => 'required',
            'archivo' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Debe ingresar un nombre.',
            'nombre.string' => 'El nombre debe  ser una cadena de caracteres o numeros, no otra cosa.',
            'visibilidad.required' => 'Debe seleccionar una visibilidad.',
        ];
    }
}
