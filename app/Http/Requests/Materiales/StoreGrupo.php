<?php

namespace App\Http\Requests\Materiales;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrupo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'asignatura_id' => 'required',
            'nombre' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'asignatura_id.required' => 'Debe seleccionar una asignatura.',
            'nombre.required' => 'Debe ingresar un nombre.',
        ];
    }
}
