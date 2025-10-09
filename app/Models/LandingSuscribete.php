<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingSuscribete extends Model
{
    use HasFactory;
    protected $table = 'landing_suscribete';
    protected $fillable = [
        'titulo',
        'subtitulo',
        'detalle',
        'imagen',
        'titulo_boton',
        'email',
        'estado',
    ];

}
