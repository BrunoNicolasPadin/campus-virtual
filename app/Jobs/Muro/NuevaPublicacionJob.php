<?php

namespace App\Jobs\Muro;

use App\Models\Muro\Muro;
use App\Models\Roles\Alumno;
use App\Notifications\Muro\NuevaPublicacionNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NuevaPublicacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $muro;

    public function __construct($muro)
    {
        $this->muro = $muro;
    }

    public function handle()
    {
        $muro = Muro::select('users.name', 'muro.user_id')
            ->join('users', 'users.id', 'muro.user_id')
            ->findOrFail($this->muro->id);
        
        $alumnos = Alumno::where('division_id', $this->muro->division_id)->get();
        $alumnos = $alumnos->filter(function($item) use($muro) {
            return $item->user_id != $muro->user_id;
        });
        Notification::send($alumnos, new NuevaPublicacionNotification($muro));
    }
}
