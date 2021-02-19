<?php

namespace App\Http\Middleware\Docentes;

use App\Models\Roles\Docente;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteYaCreado
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        if (Docente::where('user_id', Auth::id())
            ->where('institucion_id', $link[4])
            ->exists()) {
            abort(403, 'Ya estás registrado como docente para esta institución.');
        }
        return $next($request);
    }
}
