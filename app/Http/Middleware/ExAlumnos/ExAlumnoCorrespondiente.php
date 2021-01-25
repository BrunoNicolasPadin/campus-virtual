<?php

namespace App\Http\Middleware\ExAlumnos;

use App\Models\Roles\ExAlumno;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class ExAlumnoCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $exAlumno = ExAlumno::findOrFail($link[6]);

        if (session('institucion_id') == $exAlumno->institucion_id) {
            return $next($request);
        }
        abort(403, 'Este ex  alumno no pertenecio a tu institucion.');
    }
}
