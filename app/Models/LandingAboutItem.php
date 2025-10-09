<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingAboutItem extends Model
{
    use HasFactory;
    protected $table = 'landing_about_items';
    protected $fillable = [
        'titulo'
    ];
}
