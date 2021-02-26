<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreDirectivo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'claveDeAcceso' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'claveDeAcceso.required' => 'Debe ingresar una clave de acceso.',
        ];
    }
}
