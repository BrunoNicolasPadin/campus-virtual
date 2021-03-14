<?php

namespace App\Http\Controllers\Notificaciones;

use App\Http\Controllers\Controller;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use App\Models\Roles\Padre;
use Inertia\Inertia;

class NotificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (session('tipo') == 'Institucion') {
            return $this->notificacionesInstituciones();
        }
        if (session('tipo') == 'Directivo') {
            return $this->notificacionesDirectivos();
        }
        if (session('tipo') == 'Docente') {
            return $this->notificacionesDocentes();
        }
        if (session('tipo') == 'Alumno') {
            return $this->notificacionesAlumnos();
        }
        if (session('tipo') == 'Padre') {
            return $this->notificacionesPadres();
        }
        redirect(route('inicio'));
    }

    public function notificacionesInstituciones()
    {
        $institucion = Institucion::findOrFail(session('institucion_id'));

        return Inertia::render('Notificaciones/Index', [
            'notificaciones' => $institucion->unreadNotifications()->paginate(10),
        ]);
    }

    public function notificacionesDirectivos()
    {
        $directivo = Directivo::findOrFail(session('tipo_id'));

        return Inertia::render('Notificaciones/Index', [
            'notificaciones' => $directivo->unreadNotifications()->paginate(10),
        ]);
    }

    public function notificacionesDocentes()
    {
        $docente = Docente::findOrFail(session('tipo_id'));

        return Inertia::render('Notificaciones/Index', [
            'notificaciones' => $docente->unreadNotifications()->paginate(10),
        ]);
    }

    public function notificacionesAlumnos()
    {
        $alumno = Alumno::findOrFail(session('tipo_id'));

        return Inertia::render('Notificaciones/Index', [
            'notificaciones' => $alumno->unreadNotifications()->paginate(10),
        ]);
    }

    public function notificacionesPadres()
    {
        $padre = Padre::findOrFail(session('tipo_id'));

        return Inertia::render('Notificaciones/Index', [
            'notificaciones' => $padre->unreadNotifications()->paginate(10),
        ]);
    }

    public function notificacionesParaPadres()
    {
        $alumno = Alumno::findOrFail(session('alumno_id'));

        return Inertia::render('Notificaciones/ParaPadres', [
            'notificaciones' => $alumno->notifications()->paginate(10),
        ]);
    }

    public function marcarComoLeida($id)
    {
        $alumno = Alumno::findOrFail(session('tipo_id'));
        $alumno->unreadNotifications()->where('id', $id)->update(['read_at' => now()]);
        return redirect(route('notificaciones.index'))
        ->with(['successMessage' => 'Notificación marcada como leída con éxito!']);
    }
}
