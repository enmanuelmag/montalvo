<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingBlogs extends Model
{
    use HasFactory;
    protected $table = 'landing_blogs';
    protected $fillable = [
        'titulo',
        'subtitulo',
        'detalle',
        'estado',
    ];

}
