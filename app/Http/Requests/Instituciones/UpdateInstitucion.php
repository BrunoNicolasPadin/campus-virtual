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
            'numero' => 'nullable|string',
            'fundacion' => 'nullable|string',
            'historia' => 'nullable|string',
            'claveDeAccesoActual' => 'nullable',
            'claveDeAccesoNueva' => 'exclude_if:claveDeAccesoActual,null|nullable|min:8|max:32',
            'claveDeAccesoNuevaConfirmation' => 'exclude_if:claveDeAccesoActual,null|nullable|same:claveDeAccesoNueva',
            'boolArchivo' => 'required',
            'archivo' => 'exclude_if:boolArchivo,false|nullable|file|max:20480|mimetypes:application/pdf',
        ];
    }

    public function messages()
    {
        return [
            'numero.string' => 'Debe ingresar solo cadenas de caracteres (letras, números o signos) en los numeros.',
            'fundacion.string' => 'Debe ingresar solo cadenas de caracteres (letras, números o signos) en la fundación.',
            'historia.string' => 'Debe ingresar solo cadenas de caracteres (letras, números o signos) en la historia.',
            'claveDeAccesoNueva.min' => 'La clave de acceso debe tener como mínimo 8 caracteres.',
            'claveDeAccesoNueva.max' => 'La clave de acceso debe tener como máximo 32 caracteres.',
            'claveDeAccesoNuevaConfirmation.same' => 'Las claves de acceso no coinciden.',
            'archivo.file' => 'Debe ingresar un archivo, no otra cosa.',
            'archivo.max' => 'El archivo no debe superar los 20MB.',
            'archivo.mimetypes' => 'El archivo no está dentro de la lista de tipo de archivos permitidos.',
        ];
    }
}
