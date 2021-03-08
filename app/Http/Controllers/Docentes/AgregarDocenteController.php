<?php

namespace App\Http\Controllers\Docentes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreDocente;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Roles\Docente;
use App\Repositories\Estructuras\DivisionRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgregarDocenteController extends Controller
{
    protected $divisionRepository;

    public function __construct(
        DivisionRepository $divisionRepository,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('docenteCorrespondiente');

        $this->divisionRepository = $divisionRepository;
    }

    public function createAsignaturaDocente($institucion_id, $docente_id)
    {
        return Inertia::render('Docentes/CreateAsignatura', [
            'institucion_id' => $institucion_id,
            'docente' => Docente::select('docentes.id', 'users.name')
                ->join('users', 'users.id', 'docentes.user_id')
                ->orderBy('users.name')
                ->findOrFail($docente_id),
            'divisiones' => $this->divisionRepository->get($institucion_id),
        ]);
    }

    public function listarAsignaturas($institucion_id, $docente_id, $division_id)
    {
        $asignaturasDivision = Asignatura::select('asignaturas.id', 'asignaturas.nombre')
            ->where('asignaturas.division_id', $division_id)
            ->orderBy('nombre')
            ->get();

        $asignaturasDocentes = AsignaturaDocente::select('asignaturas.id', 'asignaturas.nombre')
            ->where('asignaturas_docentes.docente_id', $docente_id)
            ->join('asignaturas', 'asignaturas.id', 'asignaturas_docentes.asignatura_id')
            ->orderBy('asignaturas.nombre')
            ->get();

        foreach ($asignaturasDocentes as $asignaturaDocente) {
            $key = $asignaturasDivision->search(function($item) use ($asignaturaDocente) {
                return $item->id == $asignaturaDocente->id;
            });
            $asignaturasDivision->pull($key);
        }

        return $asignaturasDivision;
    }

    public function agregarDocente($institucion_id, $docente_id, Request $request)
    {
        for ($i=0; $i < count($request->asignatura_id); $i++) { 
            
            $asignaturaDocente = new AsignaturaDocente();
            $asignaturaDocente->asignatura()->associate($request->asignatura_id[$i]);
            $asignaturaDocente->docente()->associate($docente_id);
            $asignaturaDocente->save();
        }
        
        return redirect(route('docentes.show', [$institucion_id, $docente_id]))->with(['successMessage' => 'Asignaturas agregadas con éxito!']);
    }

    public function store(StoreDocente $request, $institucion_id)
    {

        /* $docente = new Docente();
        $docente->activado = '0';
        $docente->user()->associate(Auth::id());
        $docente->institucion()->associate($institucion_id);
        $docente->save();

        session(['tipo' => 'Directivo']);
        session(['tipo_id' => $docente->id]);
        session(['institucion_id' => $institucion_id]);
        return redirect(route('roles.mostrarCuentas'))
            ->with(['successMessage' => 'Te registraste exitosamente como docente.']); */
        
    }
}
