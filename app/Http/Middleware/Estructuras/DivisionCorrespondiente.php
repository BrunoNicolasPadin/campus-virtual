<?php

namespace App\Http\Middleware\Estructuras;

use App\Models\Estructuras\Division;
use App\Models\Instituciones\Institucion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $tipo = Auth::user()->tipo;

        if ($tipo == 'Institucion') {
            return $this->verificarInstitucion($next, $request, $link);
        }

        return abort(403, 'Usted no pertenece a esta division.');
    }

    public function verificarInstitucion($next, $request, $link)
    {
        $institucion = Institucion::where('user_id', Auth::id())->first();

        if (Division::where('id', $link[6])
            ->where('institucion_id', $institucion['id'])
            ->exists()) {
            return $next($request);
        }
    }
}
