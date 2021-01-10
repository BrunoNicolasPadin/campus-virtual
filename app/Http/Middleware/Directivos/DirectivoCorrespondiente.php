<?php

namespace App\Http\Middleware\Directivos;

use App\Models\Roles\Directivo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class DirectivoCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $directivo = Directivo::find($link[6]);

        if (session('tipo') == 'Institucion') {
            if ($directivo->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este directivo no es de tu institucion.');
        }

        if (session('tipo') == 'Directivo') {
            if ($directivo->id == session('tipo_id')) {
                return $next($request);
            }
            abort(403, 'Este directivo no eres tu.');
        }
        abort(403, 'No puedes estar aqui.');
    }
}
