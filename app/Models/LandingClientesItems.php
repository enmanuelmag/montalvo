<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingClientesItems extends Model
{
    use HasFactory;
    protected $table = 'landing_clientes_items';
    protected $fillable = [
        'titulo',
        'imagen',
        'estado',
    ];
}
