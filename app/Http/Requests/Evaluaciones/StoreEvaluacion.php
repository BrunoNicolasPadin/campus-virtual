<?php

namespace App\Http\Requests\Evaluaciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluacion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'asignatura_id' => 'required',
            'titulo' => 'required|string',
            'tipo' => 'required|string',
            'fechaHoraRealizacion' => 'required|date_format:d-m-Y H:i:s',
            'fechaHoraFinalizacion' => 'required|date_format:d-m-Y H:i:s',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'asignatura_id.required' => 'Debe seleccionar una asignatura.',
            'titulo.required' => 'Debe ingresar un titulo.',
            'tipo.required' => 'Debe ingresar un tipo de evaluacion.',
            'fechaHoraRealizacion.required' => 'Debe ingresar una fecha y hora de realizacion.',
            'fechaHoraFinalizacion.required' => 'Debe ingresar una fecha y hora de finalizacion.',
            'fechaHoraRealizacion.date_format' => 'El formato de la fecha y hora de realizacion debe ser: "DD-MM-AAAA HH:MM:SS".',
            'fechaHoraFinalizacion.date_format' => 'El formato de la fecha y hora de finalizacion debe ser: "DD-MM-AAAA HH:MM:SS".',
            'comentario.string' => 'Debe ingresar una cadena de caracteres alfanumericos.',
        ];
    }
}
