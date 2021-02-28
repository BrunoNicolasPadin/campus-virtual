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

        $archivo = EntregaArchivo::select('evaluaciones.institucion_id', 'entregas.alumno_id')
            ->join('entregas', 'entregas.id', 'entregas_archivos.entrega_id')
            ->join('evaluaciones', 'evaluaciones.id', 'entregas.evaluacion_id')
            ->join('divisiones', 'divisiones.id', 'evaluaciones.division_id')
            ->findOrFail($link[12]);

        if ($archivo->alumno_id == session('tipo_id')) {
            return $next($request);
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($archivo->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Estos archivos entregados no forma parte de tu institución');
        }

        abort(403, 'Este archivo no es tuyo.');
    }
}
