<?php

namespace App\Http\Middleware\Instituciones;

use App\Models\Instituciones\Institucion;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProhibidoInstituciones
{
    public function handle(Request $request, Closure $next)
    {
        if (Institucion::where('user_id', Auth::id())
            ->exists()) {
            return abort(403, 'Las instituciones no pueden ingresar aquí.');
        }
        return $next($request);
    }
}
