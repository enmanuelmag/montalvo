<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingOfertaLaboral extends Model
{
    use HasFactory;
    protected $table = 'landing_oferta_laboral';
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
