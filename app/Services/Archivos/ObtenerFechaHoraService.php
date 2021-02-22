<?php

namespace App\Services\Archivos;

use DateTime;
use DateTimeZone;

class ObtenerFechaHoraService
{
    public function obtenerFechaHora()
    {
        $fechaHora = new DateTime(null, new DateTimeZone('America/Argentina/Buenos_Aires'));
        $fechaHora->setTimestamp($fechaHora->getTimestamp());
        return $fechaHora->format('d-m-Y H:i:s');
    }
}