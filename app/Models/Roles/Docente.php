<?php

namespace App\Models\Roles;

use App\Models\Instituciones\Institucion;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Docente extends Model
{
    use Notifiable;

    protected $table = 'docentes';
    protected $fillable = [
        'activado',
    ];
    protected $guarded = [
        'user_id',
        'institucion_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->orderBy('name');
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
