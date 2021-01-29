<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\RendirEntrega;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class RendirEntregaCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $entrega = RendirEntrega::findOrFail($link[14]);

        if (session('tipo') == 'Alumno' ) {
            if (session('tipo_id') == $entrega->anotado->alumno_id) {
                return $next($request);
            }
            abort(403, 'No es un archivo de su entrega.');
        }

        if (session('tipo') == 'Padre' ) {
            if (session('alumno_id') == $entrega->anotado->alumno_id) {
                return $next($request);
            }
            abort(403, 'Este archivo no es de la entrega de su hijo/a.');
        }
        abort(403, 'No puede estar aqui.');
    }
}
