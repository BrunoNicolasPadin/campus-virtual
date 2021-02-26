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
            'divisiones.*.division' => 'required|string',
            'periodo_id' => 'required|integer',
            'divisiones.*.claveDeAcceso' => 'required|min:8|max:32',
            'divisiones.*.claveDeAccesoConfirmation' => 'required|same:divisiones.*.claveDeAcceso',
        ];
    }

    public function messages()
    {
        return [
            'nivel_id.required' => 'Debe seleccionar un nivel.',
            'curso_id.required' => 'Debe seleccionar un curso.',
            'periodo_id.required' => 'Debe ingresar un periodo.',
            'divisiones.*.division.required' => 'Debe ingresar una división.',
            'divisiones.*.division.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el nombre de la division.',
            'divisiones.*.claveDeAcceso.required' => 'Debe ingresar una clave de acceso.',
            'divisiones.*.claveDeAcceso.min' => 'La clave de acceso debe tener como mínimo 8 caracteres.',
            'divisiones.*.claveDeAcceso.max' => 'La clave de acceso debe tener como máximo 32 caracteres.',
            'divisiones.*.claveDeAccesoConfirmation.required' => 'Debe ingresar la clave de acceso de confirmación.',
            'divisiones.*.claveDeAccesoConfirmation.same' => 'Las claves de acceso no coinciden.',
        ];
    }
}
