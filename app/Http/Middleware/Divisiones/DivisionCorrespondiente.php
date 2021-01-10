<?php

namespace App\Http\Middleware\Divisiones;

use App\Models\Estructuras\Division;
use App\Models\Instituciones\Institucion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class DivisionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $division = Division::find($link[6]);

        if ($division->institucion_id == session('institucion_id')) {
            return $next($request);
        }
        abort(403, 'No formas partes de esta division o no forma parte de la institucion de la que formas parte.');
    }
}
