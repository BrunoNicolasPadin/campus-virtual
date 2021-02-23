<?php

namespace App\Http\Middleware\Alumnos;

use App\Services\Roles\AlumnoService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class AlumnoCorrespondiente
{
    protected $ruta;
    protected $alumnoService;

    public function __construct(
        RutaService $ruta,
        AlumnoService $alumnoService,
    )

    {
        $this->ruta = $ruta;
        $this->alumnoService = $alumnoService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        if ($this->alumnoService->AlumnoCorrespondiente($link[6])) {
            return $next($request);
        }
        abort(403, 'No puedes estar aquí.');

    }
}
