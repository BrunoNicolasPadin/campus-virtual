<?php

namespace App\Http\Middleware\Padres;

use App\Models\Roles\Padre;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PadreYaCreado
{
    public function handle(Request $request, Closure $next)
    {
        if (Padre::where('user_id', Auth::id())
            ->where('alumno_id', $request->alumno_id)
            ->exists()) {
            abort(403, 'Ya estás registrado como padre de este alumno.');
        }
        return $next($request);
    }
}
