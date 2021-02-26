<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreDirectivo;
use App\Http\Requests\Roles\StorePadre;
use App\Models\Roles\Alumno;
use App\Models\Roles\Padre;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PadreController extends Controller
{
    protected $claveDeAccesoService;

    public function __construct(VerificarInstitucion $claveDeAccesoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente')->only('show', 'destroy');
        $this->middleware('padreYaCreado')->only('store');
        $this->middleware('soloInstitucionesDirectivosPadres')->only('show', 'destroy');
        $this->middleware('padreCorrespondiente')->only('show', 'destroy');

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
            $padre = new Padre();
            $padre->activado = '0';
            $padre->user()->associate(Auth::id());
            $padre->hijos()->associate($request->alumno_id);
            $padre->save();
    
            return back()->with(['successMessage' => 'Hijo registrado con  éxito! Seleccione a otro si desea cargarlo.']);
        }
        return back()->withErrors('Este alumno no existe en esta institución.');
    }

    public function show($institucion_id, $id)
    {
        return Inertia::render('Padres/Show', [
            'institucion_id' => $institucion_id,
            'padre' => Padre::with('user', 'hijos', 'hijos.user')->findOrFail($id),
            'tipo' => session('tipo'),
        ]);
    }

    public function destroy($institucion_id, $id)
    {
        Padre::destroy($id);
        $message = 'Padre eliminado con éxito!';

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            return redirect(route('roles.index'))->with(['successMessage' => $message]);
        }

        if (session('tipo') == 'Padre' && session('tipo_id') == $id) {
            $message = 'Te eliminaste con exito!';
            session()->forget(['tipo', 'tipo_id', 'alumno_id', 'division_id', 'institucion_id']);
            return redirect(route('roles.mostrarCuentas'))->with(['successMessage' => $message]);
        }
        else {
            return back()->withErrors('Debe tener activado la cuenta que desea eliminar.');
        }

    }
}
