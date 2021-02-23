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

        $material = Material::findOrFail($link[10]);

        if (session('tipo') == 'Docente') {
            if ($this->docenteService->verificarDocenteId($material->grupo->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Este material no es de una asignatura en la que eres docente.');
        }
        abort(403, 'No puedes estar aquí.');
    }
}
