<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingItemGaleriaTrabajos extends Model
{
    use HasFactory;
    protected $table = 'landing_items_galeria_trabajos';

    protected $fillable = [
        'titulo',
        'detalle',
        'imagen',
        'landing_categoria_trabajo_id'
    ];
}
