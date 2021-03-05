<?php

namespace App\Services\Mesas;

use App\Models\Deudores\Mesa;
use App\Services\FechaHora\CambiarFormatoFechaHora;

class MesaService
{
    protected $formatoService;
    protected $obtenerFechaHoraService;

    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        $this->formatoService = $formatoService;
    }

    public function find($id)
    {
        $mesa = Mesa::select('id', 'fechaHoraRealizacion', 'fechaHoraFinalizacion')->with('asignatura')->findOrFail($id);

        return [
            'id' => $mesa->id,
            'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
        ];
    }
}

    