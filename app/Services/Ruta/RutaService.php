<?php

namespace App\Services\Ruta;

class RutaService
{
    public function obtenerRoute()
    {
        $url = url()->current();
        return preg_split('#/#', $url);
    }
}