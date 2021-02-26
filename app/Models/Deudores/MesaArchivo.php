<?php

namespace App\Models\Deudores;

use Illuminate\Database\Eloquent\Model;

class MesaArchivo extends Model
{
    protected $table = 'mesas_archivos';
    protected $fillable = [
        'archivo',
        'visibilidad',
    ];
    protected $guarded = [
        'mesa_id',
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
}
