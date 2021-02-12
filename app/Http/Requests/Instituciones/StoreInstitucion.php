<?php

namespace App\Http\Requests\Instituciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitucion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'numero' => 'nullable|string',
            'fundacion' => 'nullable|string',
            'historia' => 'nullable|string',
            'claveDeAcceso' => 'required|min:8|max:32',
            'claveDeAcceso_confirmation' => 'required|min:8|max:32|same:claveDeAcceso',
        ];
    }

    public function messages()
    {
        return [
            'numero.string' => 'Debe ingresar solo caracteres en los numeros.',
            'fundacion.string' => 'Debe ingresar solo caracteres en la fundacion.',
            'historia.string' => 'Debe ingresar solo caracteres en la historia.',
            'claveDeAcceso.required' => 'Debe ingresar una clave de acceso.',
            'claveDeAcceso.min' => 'La clave de acceso debe tener como minimo 8 caracteres.',
            'claveDeAcceso.max' => 'La clave de acceso debe tener como maximo 32 caracteres.',
            'claveDeAcceso_confirmation.same' => 'Las claves de acceso no coinciden.',
            
        ];
    }
}
