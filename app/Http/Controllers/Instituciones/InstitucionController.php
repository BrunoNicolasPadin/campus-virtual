<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInstitucion;
use App\Http\Requests\Instituciones\UpdateInstitucion;
use App\Models\Instituciones\Institucion;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        $nombre = null;

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $fecha = date_create();
            $nombre = date_timestamp_get($fecha) . '-' . $archivo->getClientOriginalName();
            $archivo->storeAs('public/PlanesDeEstudio', $nombre);
        }

        $institucion = Institucion::create([
            'user_id' => Auth::id(),
            'numero' => $request->numero,
            'fundacion' => $request->fundacion,
            'historia' => $request->historia,
            'planDeEstudio' => $nombre,
            'claveDeAcceso' => Hash::make($request->claveDeAcceso),
        ]);
                
        session(['tipo' => 'Institucion']);
        session(['institucion_id' => $institucion->id]);

        return redirect(route('ciclos-lectivos.index', $institucion->id))
            ->with(['successMessage' => 'Institución creada con éxito!']);
    }

    public function show($id)
    {
        return Inertia::render('Instituciones/Show', [
            'institucion' => Institucion::with('user')->find($id),
            'tipo'  => session('tipo'),
        ]);
    }

    public function edit($id)
    {
        return Inertia::render('Instituciones/Edit', [
            'institucion' => Institucion::with('user')->findOrFail($id),
        ]);
    }

    public function update(UpdateInstitucion $request, $id)
    {
        $nombre = null;
        $institucion = Institucion::findOrFail($id);

        if (! $request->claveDeAccesoActual === null) {
            if($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAccesoActual, $id)) {
                $institucion->claveDeAcceso = Hash::make($request->claveDeAccesoNueva);
            }
            else {
                return back()->withErrors('La clave de acceso que ingresaste en el campo "clave de acceso actual" es incorrecta.');
            }
        }

        if ($request->hasFile('archivo')) {

            Storage::delete('public/PlanesDeEstudio/' . $institucion->planDeEstudio);

            $archivo = $request->file('archivo');
            $fecha = date_create();
            $nombre = date_timestamp_get($fecha) . '-' . $archivo->getClientOriginalName();
            $archivo->storeAs('public/PlanesDeEstudio', $nombre);

            $institucion->planDeEstudio = $nombre;
        }

        $institucion->numero = $this->verificarNull($request->numero);
        $institucion->fundacion = $this->verificarNull($request->fundacion);
        $institucion->historia = $this->verificarNull($request->historia);
        $institucion->save();

        return redirect(route('instituciones.show', $id))
            ->with(['successMessage' => 'Institución actualizada con éxito!']);
    }

    public function destroy($id)
    {
        $institucion = Institucion::findOrFail($id);
        Storage::delete('public/PlanesDeEstudio/' . $institucion->planDeEstudio);

        Institucion::destroy($id);
        return redirect(route('instituciones.create'))
            ->with(['successMessage' => 'Institución eliminada con éxito']);
    }

    public function verificarNull($campo)
    {
        if ($campo == 'null') {
            return null;
        }
        return $campo;
    }
}
