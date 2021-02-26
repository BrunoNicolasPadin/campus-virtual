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
            'diaHorario.*.dia' => 'required|string',
            'diaHorario.*.horaDesde.HH' => 'required|string',
            'diaHorario.*.horaDesde.mm' => 'required|string',
            'diaHorario.*.horaHasta.HH' => 'required|string',
            'diaHorario.*.horaHasta.mm' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'diaHorario.*.dia.required' => 'Debe seleccionar un día.',
            'diaHorario.*.dia.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el dia.',
            'diaHorario.*.horaDesde.HH.required' => 'Debe seleccionar en la hora desde la/s hora/s.',
            'diaHorario.*.horaDesde.HH.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en la hora de "Hora desde".',
            'diaHorario.*.horaDesde.mm.required' => 'Debe seleccionar en la hora desde el/los minuto/s.',
            'diaHorario.*.horaDesde.mm.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en los minutos de "Hora desde".',
            'diaHorario.*.horaHasta.HH.required' => 'Debe seleccionar en la hora hasta la/s hora/s.',
            'diaHorario.*.horaHasta.HH.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en la hora de "Hora hasta".',
            'diaHorario.*.horaHasta.mm.required' => 'Debe seleccionar en la hora hasta el/los minuto/s.',
            'diaHorario.*.horaHasta.mm.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en los minutos de "Hora hasta".',
        ];
    }
}
