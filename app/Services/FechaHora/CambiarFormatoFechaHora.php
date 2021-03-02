<?php

namespace App\Services\FechaHora;

use DateTime;

class CambiarFormatoFechaHora
{
    public function cambiarFormatoParaGuardar($fechaHora)
    {
        if (! $fechaHora == '') {
            $date = new DateTime($fechaHora);
            return $date->format('Y-m-d H:i:s');
        }
        return $fechaHora;
    }

    public function cambiarFormatoParaMostrar($fechaHora)
    {
        if (! $fechaHora == '') {
            $date = new DateTime($fechaHora);
            return $date->format('d/m/Y | H:i:s');
        }
        return $fechaHora;
    }

    public function cambiarFormatoParaEditar($fechaHora)
    {
        if (! $fechaHora == '') {
            $date = new DateTime($fechaHora);
            return $date->format('Y-m-d\TH:i:s.vP');
        }
        return $fechaHora;
    }
}