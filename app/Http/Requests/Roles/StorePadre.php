<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StorePadre extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'alumno_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'alumno_id.required' => 'Debe seleccionar un alumno.',
        ];
    }
}
