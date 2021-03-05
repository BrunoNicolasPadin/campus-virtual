<?php

namespace App\Services\Archivos;

use App\Models\Deudores\Inscripcion;
use App\Models\Deudores\MesaArchivo;
use App\Models\Deudores\RendirCorreccion;
use App\Models\Deudores\RendirEntrega;
use Illuminate\Support\Facades\Storage;

class EliminarMesas
{
    public function eliminarMesas($mesa_id)
    {
        $archivos = MesaArchivo::where('mesa_id', $mesa_id)->get();

        foreach ($archivos as $archivo) {
            Storage::delete('public/Mesas/Archivos/' . $archivo->archivo);
        }

        $inscripciones = Inscripcion::where('mesa_id', $mesa_id)->get();

        foreach ($inscripciones as $inscripcion) {
            
            $this->eliminarInscripciones($inscripcion->id);
        }
    }

    public function eliminarInscripciones($inscripcion_id)
    {
        $entregas = RendirEntrega::where('inscripcion_id', $inscripcion_id)->get();
        $correcciones = RendirCorreccion::where('inscripcion_id', $inscripcion_id)->get();

        foreach ($entregas as $entrega) {
            Storage::delete('public/Deudores/Entregas/' . $entrega->archivo);
        }

        foreach ($correcciones as $correccion) {
            Storage::delete('public/Deudores/Correcciones/' . $correccion->archivo);
        }
    }
}