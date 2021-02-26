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
            'docente.*.docente_id' => 'nullable|integer',
            'diaHorario.*.dia' => 'required|string',
            'diaHorario.*.horaDesde' => 'required|string',
            'diaHorario.*.horaHasta' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Debe ingresar un nombre.',
            'nombre.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el nombre.',
            'diaHorario.*.dia.required' => 'Debe seleccionar un día.',
            'diaHorario.*.dia.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el dia.',
            'diaHorario.*.horaDesde.required' => 'Debe seleccionar una hora desde.',
            'diaHorario.*.horaHasta.required' => 'Debe seleccionar una hora hasta.',
            'diaHorario.*.horaDesde.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en la "Hora desde".',
            'diaHorario.*.horaHasta.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en la "Hora hasta".',
        ];
    }
}
