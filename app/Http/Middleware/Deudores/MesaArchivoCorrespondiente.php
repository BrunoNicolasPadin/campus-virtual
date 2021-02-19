<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Deudores\MesaArchivo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class MesaArchivoCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $archivo = MesaArchivo::findOrFail($link[12]);

        if (session('tipo') == 'Docente') {
            if (AsignaturaDocente::where('asignatura_id', $archivo->mesa->asignatura_id)->where('docente_id', session('tipo_id'))->exists()) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de la asignatura a la que pertenece este archivo.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($archivo->mesa->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este archivo no es de tu institución');
        }

        abort(403, 'No puede estar aquí.');
    }
}
