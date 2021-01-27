<?php

namespace App\Models\Deudores;

use Illuminate\Database\Eloquent\Model;

class RendirEntrega extends Model
{
    protected $table = 'rendir_entregas';
    protected $fillable = [
        'anotado_id',
        'archivo',
    ];

    public function anotado()
    {
        return $this->belongsTo(Anotado::class);
    }
}
