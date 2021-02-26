<?php

namespace App\Http\Requests\ExAlumnos;

use Illuminate\Foundation\Http\FormRequest;

class StoreExAlumno extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ciclo_lectivo_id' => 'required|integer',
            'division_id' => 'required|integer',
            'abandono' => 'required|boolean',
            'comentario' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'ciclo_lectivo_id.required' => 'Debe seleccionar un ciclo lectivo.',
            'division_id.required' => 'Debe estar en una división el alumno.',
            'abandono.required' => 'Debe informar si abandono el colegio (seleccionar) o solo se cambio (Dejar en blanco)',
            'abandono.boolean' => 'Debe ser un valor de "verdadero" o "falso" el de abandono.',
            'comentario.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el comentario.',
        ];
    }
}
