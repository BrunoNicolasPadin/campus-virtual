<?php

namespace App\Http\Requests\Estructuras;

use Illuminate\Foundation\Http\FormRequest;

class LimpiezaValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'division_id.*' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'division_id.*.required' => 'Debe seleccionar aunque sea una división.',
        ];
    }
}
