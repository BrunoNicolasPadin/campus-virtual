<?php

namespace App\Http\Middleware\Roles;

use App\Models\Instituciones\Institucion;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloInstitucionDirectivo
{
    public function handle(Request $request, Closure $next)
    {
        $tipo = Auth::user()->tipo;
        $id = Auth::id();

        if ($tipo === 'Institución') {
            return $this->verificarInstitucion($next, $request, $id);
        }
        abort(403, 'No eres una institucion o un directivo.');
    }

    public function verificarInstitucion($next, $request, $id)
    {
        if (Institucion::where('user_id', $id)
            ->exists()) {
            return $next($request);
        }
        abort(403, 'No es tu institucion.');
    }
}
