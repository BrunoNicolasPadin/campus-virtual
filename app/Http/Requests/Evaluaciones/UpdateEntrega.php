<?php

namespace App\Http\Requests\Evaluaciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntrega extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'calificacion' => 'nullable|string',
            'comentario' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'calificacion.string' => 'Debe ingresar una cadena de texto o numeros, no otra cosa.',
            'comentario.required' => 'Debe ingresar algo.',
            'comentario.string' => 'Debe ingresar una cadena de texto o numeros, no otra cosa.',
        ];
    }
}
