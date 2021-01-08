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
            'docente.*.docente_id' => 'required',
            'diaHorario.*.dia' => 'required',
            'diaHorario.*.horaDesde' => 'required',
            'diaHorario.*.horaHasta' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Debe ingresar un nombre.',
            'docente.*.docente_id.required' => 'Debe seleccionar un docente.',
            'diaHorario.*.dia.required' => 'Debe seleccionar un dia.',
            'diaHorario.*.horaDesde.required' => 'Debe seleccionar una hora desde.',
            'diaHorario.*.horaHasta.required' => 'Debe seleccionar una hora hasta.',
        ];
    }
}
