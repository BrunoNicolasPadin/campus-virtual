<?php

namespace App\Http\Middleware\Suscripciones;

use App\Models\Instituciones\Institucion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class VerificarSuscripcion
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $institucion = Institucion::select('pago')->findOrFail(session('institucion_id'));
        if ($institucion->pago) {
            return $next($request);
        }
        abort(403, 'La institución a la que pertenece no pagó el servicio. Comuniquese con ellos avisándoles de este problema.');
    }
}
