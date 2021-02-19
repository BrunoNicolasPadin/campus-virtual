<?php

namespace App\Http\Requests\Asignaturas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAsignatura extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'docente.*.docente_id' => 'nullable',
            'diaHorario.*.dia' => 'required',
            'diaHorario.*.horaDesde' => 'required',
            'diaHorario.*.horaHasta' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Debe ingresar un nombre.',
            'diaHorario.*.dia.required' => 'Debe seleccionar un día.',
            'diaHorario.*.horaDesde.required' => 'Debe seleccionar una hora desde.',
            'diaHorario.*.horaHasta.required' => 'Debe seleccionar una hora hasta.',
        ];
    }
}
