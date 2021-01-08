<?php

namespace App\Http\Requests\Libretas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLibreta extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'notas.*.calificacion' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'notas.*.calificacion' => 'Debe ser una cadena de texto o de numeros las calificaciones.',
        ];
    }
}
