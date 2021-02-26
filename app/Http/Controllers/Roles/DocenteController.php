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
            'docentes' => Docente::select('docentes.id', 'users.name', 'users.profile_photo_path')
                ->where('institucion_id', $institucion_id)
                ->join('users', 'users.id', 'docentes.user_id')
                ->orderBy('users.name')
                ->paginate(20)
                ->transform(function ($docente) {
                    return [
                        'id' => $docente->id,
                        'name'  => $docente->name,
                        'foto' => $docente->profile_photo_path,
                    ];
                }),
        ]);
    }

    public function store(StoreDocente $request, $institucion_id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $institucion_id)) {

            $docente = new Docente();
            $docente->activado = '0';
            $docente->user()->associate(Auth::id());
            $docente->institucion()->associate($institucion_id);
            $docente->save();

            session(['tipo' => 'Directivo']);
            session(['tipo_id' => $docente->id]);
            session(['institucion_id' => $institucion_id]);
            return redirect(route('roles.mostrarCuentas'))
                ->with(['successMessage' => 'Te registraste exitosamente como docente.']);
        }
        return redirect(route('roles.anotarse', $institucion_id))
            ->withErrors('Clave de acceso incorrecta.');
    }

    public function show($institucion_id, $id)
    {
        $docente = Docente::select('users.name', 'users.profile_photo_path')
            ->where('docentes.id', $id)
            ->join('users', 'users.id', 'docentes.user_id')
            ->first();

        return Inertia::render('Docentes/Show', [
            'institucion_id' => $institucion_id,
            'docente' => $docente,
        ]);
    }

    public function destroy($institucion_id, $id)
    {
        Docente::destroy($id);
        $message = 'Docente eliminado con éxito!';

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            return redirect(route('roles.index'))->with(['successMessage' => $message]);
        }

        if (session('tipo') == 'Docente') {
            $message = 'Te eliminaste con éxito!';
            session()->forget(['tipo', 'tipo_id', 'institucion_id']);
            return redirect(route('roles.mostrarCuentas'))->with(['successMessage' => $message]);
        }
        else {
            return back()->withErrors('Debe tener activado la cuenta que desea eliminar.');
        }
    }
}
