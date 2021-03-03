<?php

namespace App\Http\Requests\Evaluaciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluacionArchivo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre.*' => 'required|string',
            'visibilidad.*' => 'required|boolean',
            'archivos.*' => 'required|file|max:20480|mimetypes:application/pdf,application/msword,
            application/vnd.openxmlformats-officedocument.wordprocessingml.document,
            application/vnd.ms-excel,application/vnd.ms-powerpoint,
            application/vnd.openxmlformats-officedocument.presentationml.slideshow,
            video/avi,video/mpeg,video/quicktime,video/mp4,video/MP2T,video/x-ms-wmv,application/x-mpegURL,image/jpeg,image/png',
        ];
    }

    public function messages()
    {
        return [
            'nombre.*.required' => 'Debe ingresar un nombre.',
            'nombre.string' => 'El nombre debe  ser una cadena de caracteres (letras, numeros o signos), no otra cosa.',
            'visibilidad.*.required' => 'Debe seleccionar una visibilidad.',
            'archivos.*.required' => 'Debe ingresar un archivo.',
            'archivos.*.file' => 'Debe seleccionar un archivo, no otra cosa.',
            'archivos.*.max' => 'Cada archivo no debe superar los 20MB.',
            'archivos.*.mimetypes' => 'Hay un archivo que no esta en el tipo de archivo permitido.',
        ];
    }
}
