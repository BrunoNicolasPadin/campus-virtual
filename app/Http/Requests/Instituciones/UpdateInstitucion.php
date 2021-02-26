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
            'archivo' => 'required|file|size:20480|mimetypes:application/pdf,application/msword,
            application/vnd.openxmlformats-officedocument.wordprocessingml.document,
            application/vnd.ms-excel,application/vnd.ms-powerpoint,
            application/vnd.openxmlformats-officedocument.presentationml.slideshow,
            video/avi,video/mpeg,video/quicktime,video/mp4,video/MP2T,video/x-ms-wmv,application/x-mpegURL,image/jpeg,image/png',
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
            'archivo.required' => 'Debe ingresar un archivo.',
            'archivo.file' => 'Debe seleccionar un archivo, no otra cosa.',
            'archivo.size' => 'El archivo no debe superar los 20MB.',
            'archivo.mimetype' => 'El archivo no esta en el tipo de archivos permitidos.',
        ];
    }
}
