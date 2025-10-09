<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingServices extends Model
{
    use HasFactory;
    protected $table = 'landing_services';
    protected $fillable = [
        'title',
        'description',
        'boton_text',
        'boton_link'
    ];

}
