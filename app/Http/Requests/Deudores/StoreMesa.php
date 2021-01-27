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
            'fechaHora' => 'required|date_format:d-m-Y H:i:s',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'fechaHora.required' => 'Debe ingresar una fecha y hora de realizacion.',
            'fechaHora.date_format' => 'El formato de la fecha y hora debe ser: "DD-MM-AAAA HH:MM:SS".',
            'comentario.string' => 'Debe ingresar una cadena de caracteres y/o numeros, no otra cosa.',
        ];
    }
}
