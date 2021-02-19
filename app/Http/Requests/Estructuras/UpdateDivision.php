<?php

namespace App\Http\Requests\Estructuras;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDivision extends FormRequest
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
            'claveDeAcceso' => 'nullable|min:8|max:32',
            'claveDeAcceso_confirmation' => 'same:claveDeAcceso',
        ];
    }

    public function messages()
    {
        return [
            'nivel_id.required' => 'Debe seleccionar un nivel.',
            'curso_id.required' => 'Debe seleccionar un curso.',
            'division.required' => 'Debe ingresar una división.',
            'division.string' => 'La división deben ser solo una cadena de caracteres.',
            'periodo_id.required' => 'Debe ingresar un periodo.',
            'claveDeAcceso.min' => 'La clave de acceso debe tener como mínimo 8 caracteres.',
            'claveDeAcceso.max' => 'La clave de acceso debe tener como máximo 32 caracteres.',
            'claveDeAcceso_confirmation.same' => 'Las claves de acceso no coinciden.',
        ];
    }
}
