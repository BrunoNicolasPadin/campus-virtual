<?php

namespace App\Http\Requests\Estructuras;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormaEvaluacion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'desdeCuando' => 'exclude_if:tipo,"Escrita"|required|string',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Debe ingresar un nombre.',
            'nombre.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el nombre.',
            'tipo.required' => 'Debe seleccionar un tipo.',
            'tipo.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el tipo.',
            'desdeCuando.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en el desde cuando.',
        ];
    }
}
