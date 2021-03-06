<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\AlumnoDeudor;
use App\Models\Roles\Alumno;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class DeudaCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $deudor = AlumnoDeudor::select('alumno_id')
            ->addSelect(
                ['institucion_id' => Alumno::select('institucion_id')
                    ->whereColumn('id', 'alumno_id')
                    ->limit(1)
                ])
            ->findOrFail($link[8]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo' ) {
            if (session('institucion_id') == $deudor->institucion_id) {
                return $next($request);
            }
            abort(403, 'Esta asignatura adeudada no es de un alumno que pertenezca a tu institución.');
        }

        if (session('tipo') == 'Alumno' ) {
            if (session('tipo_id') == $deudor->alumno_id) {
                return $next($request);
            }
            abort(403, 'Esta asignatura adeudada no es tuya.');
        }

        if (session('tipo') == 'Padre' ) {
            if (session('alumno_id') == $deudor->alumno_id) {
                return $next($request);
            }
            abort(403, 'Esta asignatura adeudada no es de tu hijo.');
        }

        abort(403, 'No puede estar aquí.');
    }
}
