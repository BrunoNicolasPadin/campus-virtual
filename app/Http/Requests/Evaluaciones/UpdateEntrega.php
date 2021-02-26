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
            'calificacion' => 'nullable',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'comentario.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el comentario.',
        ];
    }
}
