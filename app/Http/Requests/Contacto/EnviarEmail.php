<?php

namespace App\Http\Requests\Contacto;

use Illuminate\Foundation\Http\FormRequest;

class EnviarEmail extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'asunto' => 'required|string',
            'mensaje' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Debe ingresar un email.',
            'email.email' => 'Debe ingresar un email VALIDO.',
            'asunto.required' => 'Debe ingresar un asunto.',
            'asunto.string' => 'Debe seleccionar una de las 5 opciones',
            'mensaje.required' => 'Debe ingresar un mensaje.',
            'mensaje.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos)',
        ];
    }
}
