<?php

namespace App\Http\Middleware\Padres;

use App\Models\Roles\Alumno;
use App\Models\Roles\Padre;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class PadreCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $padre = Padre::select('id')
        ->addSelect(
            ['institucion_id' => Alumno::select('institucion_id')
                ->whereColumn('id', 'alumno_id')
                ->limit(1)
            ])->findOrFail($link[6]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($padre->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este padre no es de tu institución.');
        }

        if (session('tipo') == 'Padre') {
            if ($padre->id == session('tipo_id')) {
                return $next($request);
            }
            abort(403, 'Este padre no eres tú.');
        }
        abort(403, 'No puedes estar aquí.');
    }
}
