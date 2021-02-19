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
            'notas.*.calificacion' => 'Debe ser una cadena de caracteres (letras, números o signos) las calificaciones.',
        ];
    }
}
