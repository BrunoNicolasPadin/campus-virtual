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
            'claveDeAccesoActual' => 'nullable',
            'claveDeAccesoNueva' => 'exclude_if:claveDeAccesoActual,null|nullable|min:8|max:32',
            'claveDeAccesoNuevaConfirmation' => 'exclude_if:claveDeAccesoActual,null|nullable|same:claveDeAccesoNueva',
        ];
    }

    public function messages()
    {
        return [
            'fundacion.string' => 'Debe ingresar solo caracteres en la fundacion.',
            'historia.string' => 'Debe ingresar solo caracteres en la historia.',
            'claveDeAccesoNueva.min' => 'La clave de acceso debe tener como minimo 8 caracteres.',
            'claveDeAccesoNueva.max' => 'La clave de acceso debe tener como maximo 32 caracteres.',
            'claveDeAccesoNuevaConfirmation.same' => 'Las claves de acceso no coinciden.',
        ];
    }
}
