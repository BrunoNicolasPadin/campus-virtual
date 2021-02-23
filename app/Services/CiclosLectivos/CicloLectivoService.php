<?php

namespace App\Services\CiclosLectivos;

use App\Models\CiclosLectivos\CicloLectivo;
use App\Services\FechaHora\CambiarFormatoFecha;

class CicloLectivoService
{
    protected $formatoService;
    protected $divisionService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->formatoService = $formatoService;
    }

    public function obtenerCiclosParaMostrar($institucion_id)
    {
        return CicloLectivo::where('institucion_id', $institucion_id)
            ->orderBy('comienzo')
            ->get()
            ->map(function ($ciclo) {
                return [
                    'id' => $ciclo->id,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                ];
            });
    }
}