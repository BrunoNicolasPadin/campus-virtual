<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Services\Roles\VerificarExistenciaUsuario;
use Closure;
use Illuminate\Http\Request;

class SoloAlumnos
{
    protected $rolesService;

    public function __construct(VerificarExistenciaUsuario $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($this->rolesService->verificarRol()) {
                return $next($request);
            }
        }
        abort(403, 'Solo los alumnos y padres pueden realizar esta acción.');
    }
}
