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
            'notas.*.calificacion' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'notas.*.calificacion.integer' => 'Debe ser un numero entero.',
        ];
    }
}
