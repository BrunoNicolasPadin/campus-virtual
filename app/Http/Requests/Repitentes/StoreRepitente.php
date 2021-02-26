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
            'alumno_id' => 'required|integer',
            'division_id' => 'required|integer',
            'ciclo_lectivo_id' => 'required|integer',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'alumno_id.required' => 'Falta el id del alumno.',
            'division_id.required' => 'Falta el id de la división.',
            'ciclo_lectivo_id.required' => 'Falta el id del ciclo lectivo.',
            'comentario.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el comentario.',
        ];
    }
}
