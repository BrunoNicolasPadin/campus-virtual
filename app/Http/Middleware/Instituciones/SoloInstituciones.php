<?php

namespace App\Http\Middleware\Instituciones;

use App\Models\Instituciones\Institucion;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloInstituciones
{
    public function handle(Request $request, Closure $next)
    {
        if (Institucion::where('user_id', Auth::id())
            ->exists()) {
            return $next($request);
        }
        return abort(403, 'Usted no es una institución.');
    }
}
