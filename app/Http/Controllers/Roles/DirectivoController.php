<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreDirectivo;
use App\Models\Roles\Directivo;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DirectivoController extends Controller
{
    protected $claveDeAccesoService;

    public function __construct(VerificarInstitucion $claveDeAccesoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente')->except('store');
        $this->middleware('soloInstitucionesDirectivos')->except('store');
        $this->middleware('directivoYaCreado')->only('store');
        $this->middleware('directivoCorrespondiente')->only('show', 'destroy');

        $this->claveDeAccesoService = $claveDeAccesoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('Directivos/Index', [
            'institucion_id' => $institucion_id,
            'directivos' => Directivo::select('directivos.id', 'users.name', 'users.profile_photo_path')
                ->where('institucion_id', $institucion_id)
                ->join('users', 'users.id', 'directivos.user_id')
                ->orderBy('users.name')
                ->paginate(20)
                ->transform(function ($directivo) {
                    return [
                        'id' => $directivo->id,
                        'name'  => $directivo->name,
                        'foto' => $directivo->profile_photo_path,
                    ];
                }),
        ]);
    }

    public function store(StoreDirectivo $request, $institucion_id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $institucion_id)) {
            $directivo = Directivo::create([
                'user_id' => Auth::id(),
                'institucion_id' => $institucion_id,
                'activado' => 0,
            ]);
            session(['tipo' => 'Directivo']);
            session(['tipo_id' => $directivo->id]);
            session(['institucion_id' => $institucion_id]);
            return redirect(route('roles.mostrarCuentas'))
                ->with(['successMessage' => 'Te registrastee exitosamente como directivo.']);
        }
        return redirect(route('roles.anotarse', $institucion_id))
            ->withErrors('Clave de acceso incorrecta.');
    }

    public function show($institucion_id, $id)
    {
        return Inertia::render('Directivos/Show', [
            'institucion_id' => $institucion_id,
            'directivo' => Directivo::with('user')->find($id),
        ]);
    }

    public function destroy($institucion_id, $id)
    {
        Directivo::destroy($id);
        $message = 'Directivo eliminado con éxito!';

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            return redirect(route('roles.index'))->with(['successMessage' => $message]);
        }

        if (session('tipo') == 'Directivo') {
            $message = 'Te eliminaste con éxito!';
            session()->forget(['tipo', 'tipo_id', 'institucion_id']);
            return redirect(route('roles.mostrarCuentas'))->with(['successMessage' => $message]);
        }
        else {
            return back()->withErrors('Debe tener activado la cuenta que desea eliminar.');
        }
    }
}
