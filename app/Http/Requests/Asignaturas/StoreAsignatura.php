<?php

namespace App\Http\Requests\Asignaturas;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsignatura extends FormRequest
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
            'diaHorario.*.horaDesde.HH' => 'required',
            'diaHorario.*.horaDesde.mm' => 'required',
            'diaHorario.*.horaHasta.HH' => 'required',
            'diaHorario.*.horaHasta.mm' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Debe ingresar un nombre.',
            'docente.*.docente_id.required' => 'Debe seleccionar un docente.',
            'diaHorario.*.dia.required' => 'Debe seleccionar un dia.',
            'diaHorario.*.horaDesde.HH.required' => 'Debe seleccionar en la hora desde la/s hora/s.',
            'diaHorario.*.horaDesde.mm.required' => 'Debe seleccionar en la hora desde el/los minuto/s.',
            'diaHorario.*.horaHasta.HH.required' => 'Debe seleccionar en la hora hasta la/s hora/s.',
            'diaHorario.*.horaHasta.HH.required' => 'Debe seleccionar en la hora hasta el/los minuto/s.',
        ];
    }
}