<?php

namespace App\Http\Middleware\Padres;

use App\Services\Roles\VerificarExistenciaUsuario;
use Closure;
use Illuminate\Http\Request;

class SoloInstitucionesDirectivosPadres
{
    protected $rolesService;

    public function __construct(VerificarExistenciaUsuario $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo' || session('tipo') == 'Padre') {
            if ($this->rolesService->verificarRol()) {
                return $next($request);
            }
        }
        
        return abort(403, 'Usted no es una institución o un directivo o un padre como para realizar tal acción.');
    }
}
