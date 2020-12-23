<?php

namespace App\Http\Middleware\Instituciones;

use App\Models\Instituciones\Institucion;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitucionYaCreada
{
    public function handle(Request $request, Closure $next)
    {
        if (Institucion::where('user_id', Auth::id())
            ->exists()) {
            abort(403, 'Usted ya esta registrado como institucion.');
        }
        return $next($request);
    }
}
