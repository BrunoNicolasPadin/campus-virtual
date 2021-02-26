<?php

namespace App\Http\Requests\Muro;

use Illuminate\Foundation\Http\FormRequest;

class StoreRespuesta extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'respuesta' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'respuesta.required' => 'Debe ingresar algo.',
            'respuesta.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en la respuesta.',
        ];
    }
}
