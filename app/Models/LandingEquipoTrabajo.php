<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingEquipoTrabajo extends Model
{
    use HasFactory;
    protected $table = 'landing_equipo_trabajo';
    protected $fillable = [
        'titulo',
        'subtitulo',
        'estado',
        'seccion_activa',
    ];
}
