<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingContactos extends Model
{
    use HasFactory;
    protected $table = 'landing_contactos';
    protected $fillable = [
        'nombre',
        'detalle',
        'email',
        'txt_btn',
         'imagen_seccion',
        'estado',
    ];
}
