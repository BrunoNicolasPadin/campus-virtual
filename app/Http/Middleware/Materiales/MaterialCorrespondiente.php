<?php

namespace App\Http\Middleware\Materiales;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Materiales\Material;
use App\Services\Roles\DocenteService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class MaterialCorrespondiente
{
    protected $ruta;
    protected $docenteService;

    public function __construct(
        RutaService $ruta, 
        DocenteService $docenteService
    )

    {
        $this->ruta = $ruta;
        $this->docenteService = $docenteService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $material = Material::select('grupos.asignatura_id', 'divisiones.institucion_id')
            ->join('grupos', 'grupos.id', 'materiales.grupo_id')
            ->join('divisiones', 'divisiones.id', 'grupos.division_id')
            ->findOrFail($link[10]);

        if (session('tipo') == 'Docente') {
            if ($this->docenteService->verificarDocenteId($material->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Este material no es de una asignatura en la que eres docente.');
        }
        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($material->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este material no forman parte de tu institución.');
        }
        abort(403, 'No puedes estar aquí.');
    }
}
