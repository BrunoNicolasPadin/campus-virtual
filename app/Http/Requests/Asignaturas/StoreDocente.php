<?php

namespace App\Http\Requests\Asignaturas;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocente extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'docente.*.docente_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'docente.*.docente_id.required' => 'Debe seleccionar un docente.',
        ];
    }
}
