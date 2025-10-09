<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingAbout extends Model
{
    use HasFactory;
    protected $table = 'landing_about';
    protected $fillable = [
        'titulo',
        'descripcion1',
        'parrafo1',
        'parrafo2',
        'btn_text',
        'btn_link',
        'imagen',
        'imagen_seccion'
    ];

}
