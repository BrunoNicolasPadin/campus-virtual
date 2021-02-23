<?php

namespace App\Http\Middleware\Docentes;

use App\Services\Roles\VerificarExistenciaUsuario;
use Closure;
use Illuminate\Http\Request;

class SoloInstitucionesDirectivosDocentes
{
    protected $rolesService;

    public function __construct(VerificarExistenciaUsuario $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->rolesService->verificarRol()) {
            return $next($request);
        }

        return abort(403, 'Usted no es una institución o un directivo o un docente como para realizar tal acción.');
    }
}
