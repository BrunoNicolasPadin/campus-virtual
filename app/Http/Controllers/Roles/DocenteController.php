<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Docentes\StoreDocente;
use App\Models\Roles\Docente;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DocenteController extends Controller
{
    protected $claveDeAccesoService;

    public function __construct(VerificarInstitucion $claveDeAccesoService)
    {
        $this->middleware('auth');
        $this->middleware('soloInstitucionDirectivo');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('docenteCorrespondiente')->only('show', 'destroy');

        $this->claveDeAccesoService = $claveDeAccesoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('Docentes/Index', [
            'institucion_id' => $institucion_id,
            'docentes' => Docente::where('institucion_id', $institucion_id)
                ->with('user')
                ->get(),
        ]);
    }

    public function store(StoreDocente $request, $institucion_id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $institucion_id)) {
            Docente::create([
                'user_id' => Auth::id(),
                'institucion_id' => $institucion_id,
            ]);
            return redirect('/dashboard');
        }
        return redirect(route('roles.index', $institucion_id))->withErrors('Clave de acceso incorrecta.');
    }

    public function show($institucion_id, $id)
    {
        return Inertia::render('Docentes/Show', [
            'institucion_id' => $institucion_id,
            'docente' => Docente::with('user')->find($id),
        ]);
    }

    public function destroy($institucion_id, $id)
    {
        Docente::destroy($id);
        return redirect(route('docentes.index', $institucion_id))->with(['successMessage' => 'Se ha eliminado el docente con exito!']);
    }
}
