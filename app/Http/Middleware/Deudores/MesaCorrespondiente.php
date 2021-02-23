<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\Mesa;
use App\Services\Asignaturas\VerificarAsignatura;
use App\Services\Mesas\DeudorService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class MesaCorrespondiente
{
    protected $ruta;
    protected $asignaturaService;
    protected $deudorService;

    public function __construct(
        RutaService $ruta,
        VerificarAsignatura $asignaturaService,
        DeudorService $deudorService,
    )

    {
        $this->ruta = $ruta;
        $this->asignaturaService = $asignaturaService;
        $this->deudorService = $deudorService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $mesa = Mesa::findOrFail($link[10]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo' ) {
            if (session('institucion_id') == $mesa->asignatura->division->institucion_id) {
                return $next($request);
            }
            abort(403, 'Esta asignatura adeudada no es de tu institución.');
        }

        if (session('tipo') == 'Docente') {
            if ($this->asignaturaService->verificarDocente($mesa->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de la asignatura a la que pertenece la mesa.');
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($this->deudorService->verificarGeneral($mesa->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'No adeuda esta asignatura.');
        }

        abort(403, 'No puede estar aqui.');
    }
}
