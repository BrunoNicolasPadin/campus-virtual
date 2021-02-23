<?php

namespace App\Http\Middleware\CiclosLectivos;

use App\Services\CiclosLectivos\VerificarCicloService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class CicloCorrespondiente
{
    protected $ruta;
    protected $cicloService;

    public function __construct(
        RutaService $ruta,
        VerificarCicloService $cicloService,
    )

    {
        $this->ruta = $ruta;
        $this->cicloService = $cicloService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        if ($this->cicloService->verificarCicloLectivo($link[6])) {
            return $next($request);
        }
        abort(403, 'Este ciclo lectivo no es de tu institución.');
    }
}
