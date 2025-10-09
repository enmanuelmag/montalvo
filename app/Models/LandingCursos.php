<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingCursos extends Model
{
    use HasFactory;
    protected $table = 'landing_cursos';

    protected $fillable = [
        'id',
        'titulo',
        'subtitulo',
        'estado',
        'created_at',
        'updated_at',
    ];
}
