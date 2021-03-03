<?php

namespace App\Http\Requests\Deudores;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArchivo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'visibilidad' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'visibilidad.required' => 'Debe seleccionar una visibilidad.',
        ];
    }
}
