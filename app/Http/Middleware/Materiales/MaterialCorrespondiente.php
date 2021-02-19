<?php

namespace App\Http\Middleware\Materiales;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Materiales\Material;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class MaterialCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $material = Material::find($link[10]);

        if (session('tipo') == 'Docente') {
            $asignaturasDocentes = AsignaturaDocente::where('asignatura_id', $material->grupo->asignatura_id)->get();

            foreach ($asignaturasDocentes as $asignaturaDocente) {
                if ($asignaturaDocente->docente_id == session('tipo_id')) {
                    return $next($request);
                }
            }
            abort(403, 'Este material no es de una asignatura en la que eres docente.');
        }
        abort(403, 'No puedes estar aquí.');
    }
}
