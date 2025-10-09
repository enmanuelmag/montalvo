<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingClientes extends Model
{
    use HasFactory;
    protected $table = 'landing_clientes';
    protected $fillable = [
        'titulo',
        'subtitulo',
        'estado',
    ];
}
