<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingBlogsDetalles extends Model
{
    use HasFactory;
    protected $table = 'landing_blogs_detalle';
    protected $fillable = [
        'titulo',
        'subtitulo',
        'detalle',
        'imagen',
        'fecha',
        'autor',
        'tipo',
        'tags',
        'estado',
    ];
}
