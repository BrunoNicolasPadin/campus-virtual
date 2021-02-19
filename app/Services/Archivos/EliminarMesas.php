<?php

namespace App\Services\Archivos;

use App\Models\Deudores\Anotado;
use App\Models\Deudores\MesaArchivo;
use App\Models\Deudores\RendirCorreccion;
use App\Models\Deudores\RendirEntrega;
use App\Models\Materiales\Material;
use Illuminate\Support\Facades\Storage;

class EliminarMesas
{
    public function eliminarMesas($mesa_id)
    {
        $archivos = MesaArchivo::where('mesa_id', $mesa_id)->get();

        foreach ($archivos as $archivo) {
            Storage::delete('public/Mesas/Archivos/' . $archivo->archivo);
        }

        $anotados = Anotado::where('mesa_id', $mesa_id)->get();

        foreach ($anotados as $anotado) {
            
            $this->eliminarInscripciones($anotado->id);
        }
    }

    public function eliminarInscripciones($anotado_id)
    {
        $entregas = RendirEntrega::where('anotado_id', $anotado_id)->get();
        $correcciones = RendirCorreccion::where('anotado_id', $anotado_id)->get();

        foreach ($entregas as $entrega) {
            Storage::delete('public/Deudores/Entregas/' . $entrega->archivo);
        }

        foreach ($correcciones as $correccion) {
            Storage::delete('public/Deudores/Correcciones/' . $correccion->archivo);
        }
    }
}