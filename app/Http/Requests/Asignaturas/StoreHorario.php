<?php

namespace App\Http\Requests\Asignaturas;

use Illuminate\Foundation\Http\FormRequest;

class StoreHorario extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
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
            'diaHorario.*.dia.required' => 'Debe seleccionar un día.',
            'diaHorario.*.horaDesde.HH.required' => 'Debe seleccionar en la hora desde la/s hora/s.',
            'diaHorario.*.horaDesde.mm.required' => 'Debe seleccionar en la hora desde el/los minuto/s.',
            'diaHorario.*.horaHasta.HH.required' => 'Debe seleccionar en la hora hasta la/s hora/s.',
            'diaHorario.*.horaHasta.HH.required' => 'Debe seleccionar en la hora hasta el/los minuto/s.',
        ];
    }
}
