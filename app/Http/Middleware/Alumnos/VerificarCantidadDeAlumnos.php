<?php

namespace App\Http\Middleware\Alumnos;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarCantidadDeAlumnos
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $institucion = Institucion::select('cantidadAlumnos')->findOrFail($link[4]);
        $cantidadAlumnosActualmente = Alumno::where('institucion_id', $link[4])->where('exAlumno', 0)->count();

        if ($cantidadAlumnosActualmente >= $institucion->cantidadAlumnos) {
            abort(403, 'Su institución alcanzó el límite de alumnos que puede registrar según lo que contrató. Comuniquese con ellos avisándoles 
            de este problema.');
        }
        return $next($request);
    }
}
