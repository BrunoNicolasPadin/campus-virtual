<?php

namespace App\Http\Middleware\Alumnos;

use App\Models\Roles\Alumno;
use App\Models\Roles\Padre;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoDivisionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $alumno = Alumno::find($link[7]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {

            if (session('institucion_id') == $alumno->institucion_id) {
                return $next($request);
            }
        }

        if (session('tipo') == 'Alumno') {

            if (Alumno::where('id', $alumno->id)
                ->where('user_id', Auth::id())
                ->exists()) {
                return $next($request);
            }
            abort(403, 'Este alumno no eres tu.');
        }

        if (session('tipo') == 'Padre') {

            if (Padre::where('user_id', Auth::id())
                ->where('alumno_id', $alumno->id)
                ->exists()) {
                return $next($request);
            }
            abort(403, 'Este/a alumno/a no es tu hijo/a.');
        }
        abort(403, 'No puedes estar aqui.');

    }
}
