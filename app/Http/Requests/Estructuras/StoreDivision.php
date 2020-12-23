<?php

namespace App\Http\Requests\Estructuras;

use Illuminate\Foundation\Http\FormRequest;

class StoreDivision extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nivel_id' => 'required|integer',
            'orientacion_id' => 'nullable|integer',
            'curso_id' => 'required|integer',
            'division' => 'required|string',
            'periodo_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'nivel_id.required' => 'Debe seleccionar un nivel.',
            'curso_id.required' => 'Debe seleccionar un curso.',
            'division.required' => 'Debe ingresar una division.',
            'division.string' => 'La division deben ser solo caracteres.',
            'periodo_id.required' => 'Debe ingresar un periodo.',
        ];
    }
}
