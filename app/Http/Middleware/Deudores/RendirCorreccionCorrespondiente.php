<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Deudores\RendirCorreccion;
use App\Models\Evaluaciones\Correccion;
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

        if (AsignaturaDocente::where('asignatura_id', $correccion->anotado->mesa->asignatura_id)->where('docente_id', session('tipo_id'))->exists()) {
            return $next($request);
        }
        abort(403, 'Usted no es docente de la asignatura a la que pertenece esta correccion.');
    }
}
