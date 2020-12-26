<?php

namespace App\Http\Requests\Evaluaciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluacion extends FormRequest
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
            'fechaHoraRealizacion' => 'required|date_format:Y-m-d H:i:s',
            'fechaHoraFinalizacion' => 'required|date_format:Y-m-d H:i:s',
            'comentario' => 'required|string',
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
            'fechaHoraRealizacion.date_format' => 'El formato de la fecha y hora de realizacion debe ser: "AAAA-MM-DD HH:MM:SS".',
            'fechaHoraFinalizacion.date_format' => 'El formato de la fecha y hora de finalizacion debe ser: "AAAA-MM-DD HH:MM:SS".',
            'comentario.required' => 'Debe ingresar un comentario.',
        ];
    }
}
