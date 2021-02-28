<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\MesaArchivo;
use App\Services\Asignaturas\VerificarAsignatura;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class MesaArchivoCorrespondiente
{
    protected $ruta;
    protected $asignaturaService;

    public function __construct(
        RutaService $ruta,
        VerificarAsignatura $asignaturaService,
    )

    {
        $this->ruta = $ruta;
        $this->asignaturaService = $asignaturaService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $archivo = MesaArchivo::select('mesas.asignatura_id', 'mesas.institucion_id')
            ->join('mesas', 'mesas.id', 'mesas_archivos.mesa_id')
            ->findOrFail($link[12]);

        if (session('tipo') == 'Docente') {
            if ($this->asignaturaService->verificarDocente($archivo->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de la asignatura a la que pertenece este archivo.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($archivo->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este archivo no es de tu institución');
        }

        abort(403, 'No puede estar aquí.');
    }
}
