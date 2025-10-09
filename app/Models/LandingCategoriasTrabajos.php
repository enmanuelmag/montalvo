<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingCategoriasTrabajos extends Model
{
    use HasFactory;
    protected $table = 'landing_categorias_trabajos';

    protected $fillable = [
        'titulo',
        'subtitulo'
    ];
}
