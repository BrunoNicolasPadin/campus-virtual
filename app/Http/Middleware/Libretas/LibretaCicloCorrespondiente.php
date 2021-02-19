<?php

namespace App\Http\Middleware\Libretas;

use App\Models\CiclosLectivos\CicloLectivo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class LibretaCicloCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $cicloLectivo = CicloLectivo::find($link[8]);

        if ($cicloLectivo->institucion_id == session('institucion_id')) {
            return $next($request);
        }
        abort(403, 'Este ciclo lectivo no forma parte de tu institución.');
    }
}
