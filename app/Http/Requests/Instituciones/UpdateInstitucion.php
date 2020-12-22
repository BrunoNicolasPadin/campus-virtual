<?php

namespace App\Http\Requests\Instituciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstitucion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'numero' => 'nullable',
            'fundacion' => 'nullable|string',
            'historia' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'fundacion.string' => 'Debe ingresar solo caracteres en la fundacion.',
            'historia.string' => 'Debe ingresar solo caracteres en la historia.',
            
        ];
    }
}
