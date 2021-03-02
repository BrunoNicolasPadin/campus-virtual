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
            'asignatura_id' => 'required|integer',
            'titulo' => 'required|string',
            'tipo' => 'required|string',
            'fechaHoraRealizacion' => 'required',
            'fechaHoraFinalizacion' => 'required',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'asignatura_id.required' => 'Debe seleccionar una asignatura.',
            'titulo.required' => 'Debe ingresar un título.',
            'titulo.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el titulo',
            'tipo.required' => 'Debe ingresar un tipo de evaluación.',
            'tipo.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el tipo de evaluacion.',
            'fechaHoraRealizacion.required' => 'Debe ingresar una fecha y hora de realización.',
            'fechaHoraFinalizacion.required' => 'Debe ingresar una fecha y hora de finalización.',
            'comentario.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el comentario.',
        ];
    }
}
