<?php

namespace App\Repositories\Deudores;

use App\Models\Deudores\Mesa;
use App\Services\FechaHora\CambiarFormatoFechaHora;

class MesaRepository
{
    protected $formatoService;

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

    