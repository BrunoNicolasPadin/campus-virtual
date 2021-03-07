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
            'claveDeAcceso.required' => 'Debe ingresar una clave de acceso.',
            'claveDeAcceso.min' => 'La clave de acceso debe tener como mínimo 8 caracteres.',
            'claveDeAcceso.max' => 'La clave de acceso debe tener como máximo 32 caracteres.',
            'claveDeAcceso_confirmation.same' => 'Las claves de acceso no coinciden.',
            'archivo.file' => 'Debe ingresar un archivo, no otra cosa.',
            'archivo.max' => 'El archivo no debe superar los 20MB.',
            'archivo.mimetypes' => 'El archivo no esta en el tipo de archivos permitidos: PDF.',
        ];
    }
}
