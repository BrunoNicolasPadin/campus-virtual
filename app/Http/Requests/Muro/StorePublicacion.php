<?php

namespace App\Http\Requests\Muro;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicacion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'publicacion' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'publicacion.required' => 'Debe ingresar algo.',
            'publicacion.string' => 'Debe ingresar una cadena de texto o numeros, no otra cosa.',
        ];
    }
}
