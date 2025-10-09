<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingNav extends Model
{
    use HasFactory;
    protected $table = 'landing_nav';
    protected $fillable = ['nombre_menu', 'ruta', 'icono','ordenamiento'];
}
