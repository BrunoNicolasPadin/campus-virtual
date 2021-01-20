<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInstitucion;
use App\Http\Requests\Instituciones\UpdateInstitucion;
use App\Models\Instituciones\Institucion;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class InstitucionController extends Controller
{
    protected $claveDeAccesoService;

    public function __construct(VerificarInstitucion $claveDeAccesoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente')->except('create', 'store');
        $this->middleware('soloInstituciones')->except('create', 'store', 'show');
        $this->middleware('institucionYaCreada')->only('create', 'store');

        $this->claveDeAccesoService = $claveDeAccesoService;
    }

    public function create()
    {
        return Inertia::render('Instituciones/Create');
    }

    public function store(StoreInstitucion $request)
    {
        $archivoStore = null;

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoStore = $archivo->getClientOriginalName();
            $archivo->storeAs('public/PlanesDeEstudio', $archivo->getClientOriginalName());
        }

        $institucion = Institucion::create([
            'user_id' => Auth::id(),
            'numero' => $request->numero,
            'fundacion' => $request->fundacion,
            'historia' => $request->historia,
            'planDeEstudio' => $archivoStore,
            'claveDeAcceso' => Hash::make($request->claveDeAcceso),
        ]);
                
        session(['tipo' => 'Institucion']);
        session(['institucion_id' => $institucion->id]);

        return redirect(route('ciclos-lectivos.index', $institucion->id))->with(['successMessage' => 'Institución cargada con éxito!']);
    }

    public function show($id)
    {
        return Inertia::render('Instituciones/Show', [
            'institucion' => Institucion::with('user')->find($id),
        ]);
    }

    public function edit($id)
    {
        return Inertia::render('Instituciones/Edit', [
            'institucion' => Institucion::with('user')->find($id),
        ]);
    }

    public function update(UpdateInstitucion $request, $id)
    {
        $archivoStore = null;
        $institucion = Institucion::findOrFail($id);

        if (! $request->claveDeAccesoActual === null) {
            if($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAccesoActual, $id)) {
                $institucion->claveDeAcceso = Hash::make($request->claveDeAccesoNueva);
            }
            return back()->withErrors('La clave de acceso que ingresaste en el campo "clave de acceso actual" es incorrecta.');
        }

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoStore = $archivo->getClientOriginalName();
            $archivo->storeAs('public/PlanesDeEstudio', $archivo->getClientOriginalName());

            $institucion->planDeEstudio = $archivoStore;

            return redirect(route('instituciones.show', $id))->with(['successMessage' => 'Institución actualizada con éxito!']);
        }

        $institucion->numero = $request->numero;
        $institucion->fundacion = $request->fundacion;
        $institucion->historia = $request->historia;
        $institucion->save();

        return redirect(route('instituciones.show', $id))->with(['successMessage' => 'Institución actualizada con éxito!']);
    }

    public function destroy($id)
    {
        Institucion::destroy($id);
        return redirect(route('instituciones.create'));
    }
}
