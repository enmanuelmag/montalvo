<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingGaleriaTrabajos extends Model
{
    use HasFactory;
    // Especifica la tabla asociada al modelo
    protected $table = 'landing_galeria_trabajos';

    // Especifica los campos que pueden ser asignados masivamente
    protected $fillable = [
        'titulo',
        'subtitulo',
        'detalle',
        'seccion_activa',
    ];
}
