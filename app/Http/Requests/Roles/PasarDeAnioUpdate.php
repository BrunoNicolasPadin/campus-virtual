<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class PasarDeAnioUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'alumno_id.*' => 'required|integer',
            'division_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'division_id.required' => 'Debe seleccionar una division.',
            'alumno_id.*.required' => 'Debe seleccionar aunque sea un alumno.',
        ];
    }
}
