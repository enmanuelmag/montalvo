<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingServicesItem extends Model
{
    use HasFactory;
    protected $table = 'landing_services_item';
    protected $fillable = [
        'title',
        'description',
        'icon'
    ];
}
