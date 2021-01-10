<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Roles\Docente;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloDocentes
{
    public function handle(Request $request, Closure $next)
    {
        if (session('tipo') == 'Docente' && Docente::where('user_id', Auth::id())->exists()) {
            return $next($request);
        }
    }
}
