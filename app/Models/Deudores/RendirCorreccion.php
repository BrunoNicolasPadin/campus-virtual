<?php

namespace App\Models\Deudores;

use Illuminate\Database\Eloquent\Model;

class RendirCorreccion extends Model
{
    protected $table = 'rendir_correcciones';
    protected $fillable = [
        'anotado_id',
        'archivo',
    ];

    public function anotado()
    {
        return $this->belongsTo(Anotado::class);
    }
}
