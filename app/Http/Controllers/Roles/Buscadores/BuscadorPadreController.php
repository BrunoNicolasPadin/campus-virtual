<?php

namespace App\Http\Controllers\Roles\Buscadores;

use App\Http\Controllers\Controller;
use App\Models\Roles\Padre;
use Inertia\Inertia;

class BuscadorPadreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
    }

    public function buscar($institucion_id, $nombre)
    {
        return Inertia::render('Padres/Index', [
            'institucion_id' => $institucion_id,
            'padres' => Padre::select('padres.id AS padre_id', 'users.name', 'alumnos.id AS alumno_id', 'users.profile_photo_path AS foto')
                ->join('alumnos', 'alumnos.id', 'padres.alumno_id')
                ->where('alumnos.institucion_id', $institucion_id)
                ->where('alumnos.exAlumno', 0)
                ->join('users', 'users.id', 'padres.user_id')
                ->when($nombre, function($query, $nombre) {
                    $query->where('users.name', 'LIKE', '%'.$nombre.'%');
                })
                ->orderBy('users.name')
                ->with(array(
                    'hijos' => function($query){
                        $query->select('id', 'user_id');
                    },
                    'hijos.user' => function($query){
                        $query->select('id', 'name');
                    },
                ))
                ->paginate(20)
                ->transform(function ($padre) {
                    return [
                        'id' => $padre->padre_id,
                        'name'  => $padre->name,
                        'foto' => $padre->profile_photo_path,
                        'hijo' => $padre->hijos,
                    ];
                }),
            'nombreProp' => $nombre,
        ]);
    }
}
