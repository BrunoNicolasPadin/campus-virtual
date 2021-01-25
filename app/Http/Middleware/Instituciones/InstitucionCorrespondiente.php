<?php

namespace App\Http\Middleware\Instituciones;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use App\Models\Roles\Padre;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitucionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        if (session('tipo') === 'Institucion') {
            return $this->verificarInstitucion($request, $next, $link);
        }
        if (session('tipo') === 'Directivo') {
            return $this->verificarDirectivo($request, $next, $link);
        }
        if (session('tipo') === 'Docente') {
            return $this->verificarDocente($request, $next, $link);
        }
        if (session('tipo') === 'Alumno' || session('tipo') == 'Ex Alumno') {
            return $this->verificarAlumno($request, $next, $link);
        }
        if (session('tipo') === 'Padre') {
            return $this->verificarPadre($request, $next, $link);
        }
        if ($link[4] == 0) {
            return $next($request);
        }
        abort(403, 'No puedes estar aqui.');
    }

    public function verificarInstitucion($request, $next, $link)
    {
        if (Institucion::where('user_id', Auth::id())
            ->where('id', $link[4])
            ->exists()) {
            return $next($request);
        }
        if ($link[4] == 0) {
            return $next($request);
        }
        abort(403, 'No es tu institucion.');
    }

    public function verificarDirectivo($request, $next, $link)
    {
        if (Directivo::where('user_id', Auth::id())
            ->where('institucion_id', $link[4])
            ->exists()) {
            return $next($request);
        }
        abort(403, 'No eres directivo en esta institucion.');
    }

    public function verificarDocente($request, $next, $link)
    {
        if (Docente::where('user_id', Auth::id())
            ->where('institucion_id', $link[4])
            ->exists()) {
            return $next($request);
        }
        abort(403, 'No eres docente en esta institucion.');
    }

    public function verificarAlumno($request, $next, $link)
    {
        if (Alumno::where('id', session('tipo_id'))
            ->where('institucion_id', $link[4])
            ->exists()) {
            return $next($request);
        }
        abort(403, 'No eres alumno en esta institucion.');
    }

    public function verificarPadre($request, $next, $link)
    {
        $padres = Padre::where('user_id', Auth::id())->get();

        foreach ($padres as $padre) {
            
            if ($padre->hijos->institucion_id == $link[4]) {
                return $next($request);
            }
        }
        abort(403, 'Tu hijo/a no forma parte de esta institucion.');
    }
    
}
