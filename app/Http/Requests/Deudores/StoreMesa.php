<?php

namespace App\Http\Requests\Deudores;

use Illuminate\Foundation\Http\FormRequest;

class StoreMesa extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fechaHora' => 'required',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'fechaHora.required' => 'Debe ingresar una fecha y hora de realización.',
            'comentario.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el comentario',
        ];
    }
}
