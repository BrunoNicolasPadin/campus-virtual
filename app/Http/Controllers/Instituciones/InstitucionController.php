<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInstitucion;
use App\Http\Requests\Instituciones\UpdateInstitucion;
use App\Models\Instituciones\Institucion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class InstitucionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente')->except('create', 'store');
        $this->middleware('soloInstituciones')->except('create', 'store');
        $this->middleware('institucionYaCreada')->only('create', 'store');
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

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoStore = $archivo->getClientOriginalName();
            $archivo->storeAs('public/PlanesDeEstudio', $archivo->getClientOriginalName());

            Institucion::where('id', $id)
                ->update([
                    'numero' => $request->numero,
                    'fundacion' => $request->fundacion,
                    'historia' => $request->historia,
                    'planDeEstudio' => $archivoStore,
                ]);

            return redirect(route('instituciones.show', $id))->with(['successMessage' => 'Institución actualizada con éxito!']);
        }

        Institucion::where('id', $id)
            ->update([
                'numero' => $request->numero,
                'fundacion' => $request->fundacion,
                'historia' => $request->historia,
            ]);
        return redirect(route('instituciones.show', $id))->with(['successMessage' => 'Institución actualizada con éxito!']);
    }

    public function destroy($id)
    {
        Institucion::destroy($id);
        return back();
    }
}
