<?php

namespace App\Http\Controllers\Roles\Buscadores;

use App\Http\Controllers\Controller;
use App\Models\Roles\Alumno;
use Inertia\Inertia;

class BuscadorAlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
    }

    public function buscar($institucion_id, $nombre)
    {
        return Inertia::render('Alumnos/Index', [
            'institucion_id' => $institucion_id,
            'alumnos' => Alumno::select('users.name', 'users.profile_photo_path', 'alumnos.id')
                ->where('institucion_id', $institucion_id)
                ->join('users', 'users.id', 'alumnos.user_id')
                ->when($nombre, function($query, $nombre) {
                    $query->where('users.name', 'LIKE', '%'.$nombre.'%');
                })
                ->orderBy('users.name')
                ->paginate(20),
            'nombreProp' => $nombre,
        ]);
    }
}
