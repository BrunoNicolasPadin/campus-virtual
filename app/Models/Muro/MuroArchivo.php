<?php

namespace App\Models\Muro;

use Illuminate\Database\Eloquent\Model;

class MuroArchivo extends Model
{
    protected $table = 'muro_archivos';
    protected $fillable = [
        'muro_id',
        'archivo',
    ];

    public function muro()
    {
        return $this->belongsTo(Muro::class);
    }
}
