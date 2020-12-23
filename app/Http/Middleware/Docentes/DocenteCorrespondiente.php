<?php

namespace App\Http\Middleware\Docentes;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Docente;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteCorrespondiente
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

        if ($tipo == 'Institución') {
            return $this->verificarInstitucion($next, $request, $link);
        }

        return abort(403, 'Solo los directivos pueden entrar aqui.');
    }

    public function verificarInstitucion($next, $request, $link)
    {
        $institucion = Institucion::where('user_id', Auth::id())->first();

        if (Docente::where('id', $link[6])
            ->where('institucion_id', $institucion['id'])
            ->exists()) {
            return $next($request);
        }
        return abort(403, 'Este docente no forma parte de su institucion.');
    }
}
