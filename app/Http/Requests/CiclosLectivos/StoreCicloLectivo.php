<?php

namespace App\Http\Requests\CiclosLectivos;

use Illuminate\Foundation\Http\FormRequest;

class StoreCicloLectivo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comienzo' => 'required|date',
            'final' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'comienzo.required' => 'Debe ingresar una fecha de comienzo.',
            'final.required' => 'Debe ingresar una fecha de final.',
            'comienzo.date' => 'Debe ingresar una fecha de comienzo en formato "DD-MM-AAAA.',
            'final.date' => 'Debe ingresar una fecha de final en formato "DD-MM-AAAA.',
        ];
    }
}
