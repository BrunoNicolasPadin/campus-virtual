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
            'fechaHoraRealizacion' => 'required',
            'fechaHoraFinalizacion' => 'required',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'fechaHoraRealizacion.required' => 'Debe ingresar una fecha y hora de realización.',
            'fechaHoraFinalizacion.required' => 'Debe ingresar una fecha y hora de finalización.',
            'comentario.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el comentario',
        ];
    }
}
