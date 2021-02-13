<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreDocente;
use App\Models\Roles\Docente;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DocenteController extends Controller
{
    protected $claveDeAccesoService;

    public function __construct(VerificarInstitucion $claveDeAccesoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente')->except('store');
        $this->middleware('soloInstitucionesDirectivos')->only('index');
        $this->middleware('docenteYaCreado')->only('store');
        $this->middleware('soloInstitucionesDirectivosDocentes')->only('show', 'destroy');
        $this->middleware('docenteCorrespondiente')->only('show', 'destroy');

        $this->claveDeAccesoService = $claveDeAccesoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('Docentes/Index', [
            'institucion_id' => $institucion_id,
            'docentes' => Docente::select('docentes.id', 'users.name')
                ->where('institucion_id', $institucion_id)
                ->join('users', 'users.id', 'docentes.user_id')
                ->orderBy('users.name')
                ->paginate(20)
                ->transform(function ($docente) {
                    return [
                        'id' => $docente->id,
                        'name'  => $docente->name,
                    ];
                }),
        ]);
    }

    public function store(StoreDocente $request, $institucion_id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $institucion_id)) {
            $docente = Docente::create([
                'user_id' => Auth::id(),
                'institucion_id' => $institucion_id,
                'activado' => 0,
            ]);
            session(['tipo' => 'Directivo']);
            session(['tipo_id' => $docente->id]);
            session(['institucion_id' => $institucion_id]);
            return redirect(route('roles.mostrarCuentas'));
        }
        return redirect(route('roles.anotarse', $institucion_id))->withErrors('Clave de acceso incorrecta.');
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
        $message = 'Docente eliminado con exito!';

        if (session('tipo') == 'Docente') {
            $message = 'Te eliminaste con exito!';
            session()->forget(['tipo', 'tipo_id', 'institucion_id']);
        }
        else {
            return back()->withErrors('Debe tener activado la cuenta que desea eliminar.');
        }

        return redirect(route('roles.mostrarCuentas'))->with(['successMessage' => $message]);
    }
}
