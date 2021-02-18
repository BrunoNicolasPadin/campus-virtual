<?php

namespace App\Services\Archivos;

use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Archivo;
use App\Models\Evaluaciones\Correccion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\EntregaArchivo;
use Illuminate\Support\Facades\Storage;

class EliminarEntregasCorrecciones
{
    public function eliminarEntregasCorrecciones($evaluacion_id)
    {
        $archivos = Archivo::where('evaluacion_id', $evaluacion_id)->get();
        foreach ($archivos as $archivo) {
            Storage::delete('public/Evaluaciones/Archivos/' . $archivo->archivo);
        }

        $entregas = Entrega::where('evaluacion_id', $evaluacion_id)->get();
        foreach ($entregas as $entrega) {

            $entregasArchivos = EntregaArchivo::where('entrega_id', $entrega->id)->get();
            foreach ($entregasArchivos as $archivo) {
                Storage::delete('public/Evaluaciones/Entregas/' . $archivo->archivo);
            }

            $correccionesArchivos = Correccion::where('entrega_id', $entrega->id)->get();
            foreach ($correccionesArchivos as $archivo) {
                Storage::delete('public/Evaluaciones/Correcciones/' . $archivo->archivo);
            }
        }
    }
}