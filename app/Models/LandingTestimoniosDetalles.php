<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingTestimoniosDetalles extends Model
{
    use HasFactory;
    protected $table = 'landing_testimonios_detalle';
    protected $fillable = [
        'nombre',
        'detalle',
        'imagen',
        'cargo',
        'empresa',
        'calificacion',
        'estado',
    ];

}
