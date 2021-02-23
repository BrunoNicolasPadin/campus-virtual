<?php

namespace App\Http\Middleware\Repitentes;

use App\Models\Repitentes\Repitente;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class RepitenteCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $repitente = Repitente::findOrFail($link[6]);

        if (session('institucion_id') == $repitente->institucion_id) {
            return $next($request);
        }
        abort(403, 'Este repitente no pertenece a tu institución.');
    }
}
