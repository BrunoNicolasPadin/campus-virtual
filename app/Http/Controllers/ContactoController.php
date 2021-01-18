<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contacto\EnviarEmail;
use App\Mail\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function enviarEmail(Request $request)
    {
        $to_email = "gescolcontacto@gmail.com";

        $details = [
            'titulo' => 'Contacto de ' . $request->email,
            'email' => $request->email,
            'mensaje' => $request->mensaje,
            'asunto' => $request->asunto,
        ];

        Mail::to($to_email)->send(new Contacto($details));
        return back();

    }
}
