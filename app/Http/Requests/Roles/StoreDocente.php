<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocente extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'claveDeAcceso' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'claveDeAcceso.required' => 'Debe ingresar una clave de acceso.',
        ];
    }
}
