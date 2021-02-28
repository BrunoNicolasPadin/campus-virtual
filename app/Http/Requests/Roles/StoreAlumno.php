<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumno extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'division_id' => 'required',
            'claveDeAcceso' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'division_id.required' => 'Debe seleccionar una división.',
            'claveDeAcceso.required' => 'Debe seleccionar una clave de acceso.',
        ];
    }
}
