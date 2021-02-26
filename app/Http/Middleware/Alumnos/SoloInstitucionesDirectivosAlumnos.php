<?php

namespace App\Http\Middleware\Alumnos;

use App\Services\Roles\VerificarExistenciaUsuario;
use Closure;
use Illuminate\Http\Request;

class SoloInstitucionesDirectivosAlumnos
{
    protected $rolesService;

    public function __construct(VerificarExistenciaUsuario $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo' || session('tipo') == 'Alumno') {
            if ($this->rolesService->verificarRol()) {
                return $next($request);
            }
        }

        abort(403, 'Usted no es una institución o un directivo o un alumno como para realizar tal acción.');
    }
}
