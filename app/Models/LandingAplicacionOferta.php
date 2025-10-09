<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingAplicacionOferta extends Model
{
    use HasFactory;
    protected $table = 'landing_aplicacion_ofertas';
    protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'correo',
        'hoja_vida',
        'oferta_id',
    ];
    public function ofertaLaboral()
    {
        return $this->belongsTo(LandingOfertaLaboral::class, 'oferta_id');
    }
}
