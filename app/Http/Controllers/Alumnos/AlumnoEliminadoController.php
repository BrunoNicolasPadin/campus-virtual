<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
use App\Models\Roles\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AlumnoEliminadoController extends Controller
{
    public function __construct()

    {
        $this->middleware('auth');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('alumnoCorrespondiente')->only('eliminacionDefinitiva');
    }

    public function index($institucion_id, Request $request)
    {
        return Inertia::render('Alumnos/Eliminados/Index', [
            'institucion_id' => $institucion_id,
            'alumnos' => Alumno::select('alumnos.id', 'users.name', 'users.profile_photo_path')
                ->where('institucion_id', $institucion_id)
                ->where('alumnos.eliminado', '1')
                ->join('users', 'users.id', 'alumnos.user_id')
                ->when($request->nombre, function($query, $nombre) {
                    $query->where('users.name', 'LIKE', '%'.$nombre.'%');
                })
                ->orderBy('users.name')
                ->paginate(20)
                ->transform(function ($alumno) {
                    return [
                        'id' => $alumno->id,
                        'name'  => $alumno->name,
                        'foto' => $alumno->profile_photo_path,
                    ];
                }),
            'nombreProp' => $request->nombre,
        ]);
    }

    public function eliminacionDefinitiva($institucion_id, $id)
    {
        Alumno::destroy($id);
        return redirect(route('alumnosEliminados.index', $institucion_id))->with(['successMessage' => 'Eliminación definitiva realizada con éxito!']);
    }
}
