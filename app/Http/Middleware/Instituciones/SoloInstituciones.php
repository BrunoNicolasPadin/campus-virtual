<?php

namespace App\Http\Middleware\Instituciones;

use App\Services\Roles\VerificarExistenciaUsuario;
use Closure;
use Illuminate\Http\Request;

class SoloInstituciones
{
    protected $rolesService;

    public function __construct(VerificarExistenciaUsuario $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (session('tipo') == 'Institucion') {
            if ($this->rolesService->verificarRol()) {
                return $next($request);
            }
        }
        return abort(403, 'Usted no es una institución.');
    }
}
