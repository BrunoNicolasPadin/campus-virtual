<?php

namespace App\Services\FechaHora;

use DateTime;

class CambiarFormatoFecha
{
    public function cambiarFormatoParaGuardar($fecha)
    {
        $date = new DateTime($fecha);
        return $date->format('Y-m-d');
    }

    public function cambiarFormatoParaMostrar($fecha)
    {
            $date = new DateTime($fecha);
            return $date->format('d-m-Y');
    }
}