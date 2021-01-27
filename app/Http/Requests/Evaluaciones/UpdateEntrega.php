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
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'calificacion.string' => 'Debe ingresar una cadena de texto o numeros en la calificacion, no otra cosa.',
            'comentario.string' => 'Debe ingresar una cadena de texto o numeros en el comentario, no otra cosa.',
        ];
    }
}
