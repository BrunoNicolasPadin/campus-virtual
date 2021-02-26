<?php

namespace App\Http\Requests\Estructuras;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormaDescripcion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'opcion' => 'required|string',
            'aprobado' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'opcion.required' => 'Debe ingresar una opción.',
            'opcion.string' => 'Debe ingresar una cadena de caracteres (letras, numeros o signos) en la opción.',
            'aprobado.required' => 'Debe ingresar si significa "aprobado" o no.',
            'aprobado.boolean' => 'El campo "aprobado" debe ser un valor booleano.',
        ];
    }
}
