<?php

namespace App\Http\Controllers\Roles\Buscadores;

use App\Http\Controllers\Controller;
use App\Models\Roles\Directivo;
use Inertia\Inertia;

class BuscadorDirectivoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
    }

    public function buscar($institucion_id, $nombre)
    {
        return Inertia::render('Directivos/Index', [
            'institucion_id' => $institucion_id,
            'directivos' => Directivo::select('users.name', 'users.profile_photo_path', 'directivos.id')
                ->where('institucion_id', $institucion_id)
                ->join('users', 'users.id', 'directivos.user_id')
                ->when($nombre, function($query, $nombre) {
                    $query->where('users.name', 'LIKE', '%'.$nombre.'%');
                })
                ->orderBy('users.name')
                ->paginate(10),
            'nombreProp' => $nombre,
        ]);
    }
}
