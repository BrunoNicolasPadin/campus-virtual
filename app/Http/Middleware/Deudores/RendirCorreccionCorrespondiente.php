<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Deudores\RendirCorreccion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class RendirCorreccionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $correccion = RendirCorreccion::findOrFail($link[14]);

        if (session('tipo') == 'Docente') {
            if ($this->asignaturaService->verificarDocente($correccion->anotado->mesa->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de la asignatura a la que pertenece esta corrección.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($correccion->anotado->mesa->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta corrección no es de tu institución');
        }
    }
}
