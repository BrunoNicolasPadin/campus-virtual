<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\RendirEntrega;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class RendirEntregaCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $entrega = RendirEntrega::select('anotados.alumno_id', 'mesas.institucion_id')
            ->join('anotados', 'anotados.id', 'rendir_entregas.anotado_id')
            ->join('mesas', 'mesas.id', 'anotados.mesa_id')
            ->first($link[14]);

        if (session('tipo') == 'Alumno' ) {
            if (session('tipo_id') == $entrega->alumno_id) {
                return $next($request);
            }
            abort(403, 'Este archivo no es tuyo.');
        }

        if (session('tipo') == 'Padre' ) {
            if (session('alumno_id') == $entrega->alumno_id) {
                return $next($request);
            }
            abort(403, 'Este archivo no es de la entrega de su hijo/a.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($entrega->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta entrega no es de tu institución');
        }

        abort(403, 'No puede estar aquí.');
    }
}
