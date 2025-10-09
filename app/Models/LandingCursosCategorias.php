<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingCursosCategorias extends Model
{
    use HasFactory;
    protected $table = 'landing_cursos_categorias';

    protected $fillable = [
        'id',
        'titulo',
        'subtitulo',
        'estado',
        'created_at',
        'updated_at',
    ];
}
