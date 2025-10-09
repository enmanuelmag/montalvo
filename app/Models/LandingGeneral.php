<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingGeneral extends Model
{
    use HasFactory;
    protected $table = 'landing_general';
    protected $fillable = [
        'titulo',
        'subtitulo',
        'descripcion',
        'imagen',
        'btn_text',
        'btn_link'
    ];
}
