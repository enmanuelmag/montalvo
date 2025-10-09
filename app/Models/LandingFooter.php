<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingFooter extends Model
{
    use HasFactory;
    protected $table = 'landing_footer';
    protected $fillable = [
        'titulo_1',
        'titulo_2',
        'titulo_3',
        'direccion',
        'telefono',
        'email',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
    ];
}
