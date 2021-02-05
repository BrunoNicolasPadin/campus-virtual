<?php

namespace App\Http\Requests\ExAlumnos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExAlumno extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ciclo_lectivo_id' => 'required',
            'abandono' => 'required',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'ciclo_lectivo_id.required' => 'Debe seleccionar un ciclo lectivo.',
            'abandono.required' => 'Debe informar si abandono el colegio (seleccionar) o solo se cambio (Dejar en blanco).',
            'comentario.string' => 'Si desea ingresar un comentario debera ser una candena de caracteres.',
        ];
    }
}
