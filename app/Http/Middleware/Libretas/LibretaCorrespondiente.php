<?php

namespace App\Http\Middleware\Libretas;

use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Libretas\Libreta;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class LibretaCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $libreta = Libreta::select('id')
            ->addSelect(
                ['institucion_id' => CicloLectivo::select('institucion_id')
                    ->whereColumn('id', 'ciclo_lectivo_id')
                    ->limit(1)
                ])
        ->findOrFail($link[8]);

        if ($libreta->institucion_id == session('institucion_id')) {
            
            return $next($request);
        }
        abort(403, 'Esta libreta no es de tu institución.');
    }
}
