<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\Anotado;
use App\Models\Roles\Alumno;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarInscripcion
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $alumno = Alumno::where('user_id', Auth::id())->where('institucion_id', session('institucion_id'))->first();

        if (Anotado::where('alumno_id', $alumno['id'])->where('mesa_id', $link[10])->exists()) {
            abort(403, 'No puede inscribirse dos veces.');
        }
        return $next($request);
    }
}
