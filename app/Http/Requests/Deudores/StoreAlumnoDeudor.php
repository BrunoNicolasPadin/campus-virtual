<?php

namespace App\Http\Requests\Deudores;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumnoDeudor extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ciclo_lectivo_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'ciclo_lectivo_id.required' => 'Debe seleccionar un ciclo lectivo.',
        ];
    }
}
