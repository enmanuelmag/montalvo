<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingCursosDetalles extends Model
{
    use HasFactory;
    protected $table = 'landing_cursos_detalles';

    protected $fillable = [
        'id',
        'titulo',
        'subtitulo',
        'categoria_id',
        'detalle',
        'imagen',
        'video',
        'precio',
        'duracion',
        'fecha_inicio',
        'fecha_fin',
        'horario',
        'lugar',
        'requisitos',
        'dirigido',
        'metodologia',
        'certificacion',
        'calificacion',
        'estado',
        'created_at',
        'updated_at',
        'resumen',
        'unidad_duracion',
    ];
}
