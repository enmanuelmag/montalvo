<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingItemEquipoTrabajo extends Model
{
    use HasFactory;
    protected $table = 'landing_item_equipo_trabajo';
    protected $fillable = [
        'nombre',
        'cargo',
        'descripcion',
        'imagen',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'youtube',
        'estado',
    ];
}
