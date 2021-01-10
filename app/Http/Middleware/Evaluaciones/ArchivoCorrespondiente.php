<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\Archivo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class ArchivoCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $archivo = Archivo::find($link[10]);

        $asignaturasDocentes = AsignaturaDocente::where('asignatura_id', $archivo->evaluacion->asignatura_id)->get();

        foreach ($asignaturasDocentes as $asignaturaDocente) {
            if ($asignaturaDocente->docente_id == session('tipo_id')) {
                return $next($request);
            }
        }
        abort(403, 'Este archivo forma parte de una evaluacion en una asignatura de la que no eres docente.');
    }
}
