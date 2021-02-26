<?php

namespace App\Http\Middleware\CiclosLectivos;

use App\Services\Roles\VerificarExistenciaUsuario;
use Closure;
use Illuminate\Http\Request;

class SoloInstitucionesDirectivos
{
    protected $rolesService;

    public function __construct(VerificarExistenciaUsuario $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($this->rolesService->verificarRol()) {
                return $next($request);
            }
        }

        abort(403, 'Usted no es una institución o un directivo.');
    }
}
