<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInstitucion;
use App\Http\Requests\Instituciones\UpdateInstitucion;
use App\Jobs\Instituciones\InstitucionDestroyJob;
use App\Models\Instituciones\Institucion;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class InstitucionController extends Controller
{
    protected $claveDeAccesoService;
    protected $obtenerFechaHoraService;

    public function __construct(
        VerificarInstitucion $claveDeAccesoService,
        ObtenerFechaHoraService $obtenerFechaHoraService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente')->except('create', 'store');
        $this->middleware('soloInstituciones')->except('create', 'store', 'show');
        $this->middleware('institucionYaCreada')->only('create', 'store');

        $this->claveDeAccesoService = $claveDeAccesoService;
        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
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
            $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
            $unique = substr(base64_encode(mt_rand()), 0, 15);
            $nombre = $fechaHora . '-' . $unique . '-' . $archivo->getClientOriginalName();
            $archivo->storeAs('PlanesDeEstudio', $nombre, 's3');
        }

        $institucion = new Institucion();
        $institucion->numero = $this->verificarNull($request->numero);
        $institucion->fundacion = $this->verificarNull($request->fundacion);
        $institucion->historia = $this->verificarNull($request->historia);
        $institucion->planDeEstudio = $nombre;
        $institucion->claveDeAcceso = Hash::make($request->claveDeAcceso);
        $institucion->user()->associate(Auth::id());
        $institucion->save();
                
        session(['tipo' => 'Institucion']);
        session(['institucion_id' => $institucion->id]);

        return redirect(route('ciclos-lectivos.index', $institucion->id))
            ->with(['successMessage' => 'Institución creada con éxito!']);
    }

    public function show($id)
    {
        $institucion = Institucion::select('id', 'user_id', 'cantidadAlumnos', 'pago', 'numero', 'fundacion', 'historia', 'planDeEstudio')
            ->where('id', $id)
            ->with(array(
                'user' => function($query){
                    $query->select('id', 'name', 'profile_photo_path');
                },
            ))
            ->first();

        return Inertia::render('Instituciones/Show', [
            'institucion' => $institucion,
            'tipo'  => session('tipo'),
        ]);
    }

    public function edit($id)
    {
        $institucion = Institucion::select('id', 'user_id', 'numero', 'fundacion', 'historia', 'planDeEstudio')
            ->where('id', $id)
            ->with(array(
                'user' => function($query){
                    $query->select('id', 'name', 'profile_photo_path');
                },
            ))
            ->first();

        return Inertia::render('Instituciones/Edit', [
            'institucion' => $institucion,
        ]);
    }

    public function update(UpdateInstitucion $request, $id)
    {
        $nombre = null;
        $institucion = Institucion::findOrFail($id);

        if (! $request->claveDeAccesoActual === null) {
            /* if($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAccesoActual, $id)) { */
                $institucion->claveDeAcceso = Hash::make($request->claveDeAccesoNueva);
            /* }
            else {
                return back()->withErrors('La clave de acceso que ingresaste en el campo "clave de acceso actual" es incorrecta.');
            } */
        }

        if ($request->hasFile('archivo')) {

            Storage::delete('PlanesDeEstudio/' . $institucion->planDeEstudio);
            $archivo = $request->file('archivo');
            $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
            $unique = substr(base64_encode(mt_rand()), 0, 15);
            $nombre = $fechaHora . '-' . $unique . '-' . $archivo->getClientOriginalName();
            $archivo->storeAs('PlanesDeEstudio', $nombre, 's3');
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
        InstitucionDestroyJob::dispatch($id);

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
