<?php

namespace App\Http\Middleware\Repetidores;

use App\Models\Repetidores\Repetidor;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class RepetidorCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $repetidor = Repetidor::find($link[6]);

        if (session('institucion_id') == $repetidor->institucion_id) {
            return $next($request);
        }
        abort(403, 'Este alumno que repitio no pertenece a su institucion.');
    }
}
