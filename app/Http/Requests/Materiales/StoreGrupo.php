<?php

namespace App\Http\Requests\Materiales;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrupo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'asignatura_id' => 'required|integer',
            'nombre' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'asignatura_id.required' => 'Debe seleccionar una asignatura.',
            'nombre.required' => 'Debe ingresar un nombre.',
            'nombre.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el nombre.',
        ];
    }
}
