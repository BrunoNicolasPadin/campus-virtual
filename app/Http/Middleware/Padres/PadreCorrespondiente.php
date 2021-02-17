<?php

namespace App\Http\Middleware\Padres;

use App\Models\Roles\Padre;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class PadreCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $padre = Padre::with('hijos')->find($link[6]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($padre->hijos->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este padre no es de tu institucion.');
        }

        if (session('tipo') == 'Padre') {
            if ($padre->id == session('tipo_id')) {
                return $next($request);
            }
            abort(403, 'Este padre no eres tu.');
        }
        abort(403, 'No puedes estar aqui.');
    }
}
