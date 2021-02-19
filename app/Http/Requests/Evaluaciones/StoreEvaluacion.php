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
            'titulo.required' => 'Debe ingresar un título.',
            'tipo.required' => 'Debe ingresar un tipo de evaluación.',
            'fechaHoraRealizacion.required' => 'Debe ingresar una fecha y hora de realización.',
            'fechaHoraFinalizacion.required' => 'Debe ingresar una fecha y hora de finalización.',
            'fechaHoraRealizacion.date_format' => 'El formato de la fecha y hora de realización debe ser: "DD-MM-AAAA HH:MM:SS".',
            'fechaHoraFinalizacion.date_format' => 'El formato de la fecha y hora de finalización debe ser: "DD-MM-AAAA HH:MM:SS".',
            'comentario.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos)',
        ];
    }
}
