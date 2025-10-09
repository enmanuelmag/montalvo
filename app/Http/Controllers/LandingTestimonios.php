<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingTestimonios extends Model
{
    use HasFactory;
    protected $table = 'landing_testimonios';
    protected $fillable = [
        'titulo',
        'subtitulo',
        'estado',
    ];

}
