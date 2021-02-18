<?php

namespace App\Http\Requests\Repitentes;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepitente extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'alumno_id' => 'required',
            'division_id' => 'required',
            'ciclo_lectivo_id' => 'required',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'alumno_id.required' => 'Falta el id del alumno.',
            'division_id.required' => 'Falta el id de la division.',
            'ciclo_lectivo_id.required' => 'Falta el id del ciclo lectivo.',
            'comentario.string' => 'Debe ingresar una cadena de texto o numeros, no otra cosa.',
        ];
    }
}
