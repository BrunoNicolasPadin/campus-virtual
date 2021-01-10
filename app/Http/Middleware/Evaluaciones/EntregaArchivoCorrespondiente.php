<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Evaluaciones\EntregaArchivo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class EntregaArchivoCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $archivo = EntregaArchivo::find($link[12]);

        if ($archivo->entrega->alumno_id == session('tipo_id')) {
            return $next($request);
        }
        abort(403, 'Este archivo no es tuyo.');
    }
}
