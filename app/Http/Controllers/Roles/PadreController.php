<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreDirectivo;
use App\Http\Requests\Roles\StorePadre;
use App\Models\Roles\Alumno;
use App\Models\Roles\Padre;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PadreController extends Controller
{
    protected $claveDeAccesoService;

    public function __construct(VerificarInstitucion $claveDeAccesoService)
    {
        $this->middleware('auth');

        $this->claveDeAccesoService = $claveDeAccesoService;
    }

    public function verificarClave($institucion_id, StoreDirectivo $request)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $institucion_id)) {
            return redirect(route('padres.create', $institucion_id));
        }
        return redirect(route('roles.anotarse', $institucion_id))->withErrors('Clave de acceso incorrecta.');
    }

    public function create($institucion_id)
    {
        return Inertia::render('Padres/Create', [
            'institucion_id' => $institucion_id,
            'alumnos' => Alumno::select('users.name', 'alumnos.id')
                ->where('institucion_id', $institucion_id)
                ->join('users', 'users.id', 'alumnos.user_id')
                ->orderBy('users.name')
                ->get(),
        ]);
    }

    public function store(StorePadre $request, $institucion_id)
    {
        if (Alumno::where('id', $request->alumno_id)->where('institucion_id', $institucion_id)->exists()) {
            Padre::create([
                'user_id' => Auth::id(),
                'alumno_id' => $request->alumno_id,
                'activado' => 0,
            ]);
    
            return back()->with(['successMessage' => 'Hijo registrado con  exito! Seleccione a otro si desea cargarlo.']);
        }
        return back()->withErrors('Este alumno no existe en esta institucion.');
    }

    public function show($institucion_id, $id)
    {
        $padre = Padre::with('user')->find($id);

        return Inertia::render('Padres/Show', [
            'institucion_id' => $institucion_id,
            'padre' => $padre,
            'padres' => Padre::with('user', 'hijos', 'hijos.user')->where('user_id', $padre->user_id)->get(),
        ]);
    }

    public function destroy($institucion_id, $id)
    {
        Padre::destroy($id);
        return redirect(route('padres.index', $institucion_id))->with(['successMessage' => 'Se ha eliminado el padre con exito!']);
    }
}
