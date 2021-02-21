<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActualizacionLibreta extends Mailable
{
    use Queueable, SerializesModels;

    public $detalles;

    public function __construct($detalles)
    {
        $this->detalles = $detalles;
    }

    public function build()
    {
        return $this->subject($this->detalles['asunto'])->from($this->detalles['email'])->view('emails.actualizacion-libreta');
    }
}
