<?php

namespace App\Http\Requests\Evaluaciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreComentario extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comentario' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'comentario.required' => 'Debe ingresar algo.',
            'comentario.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el comentario',
        ];
    }
}
