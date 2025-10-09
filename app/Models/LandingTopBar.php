<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingTopBar extends Model
{
    use HasFactory;
    protected $table = 'landing_top_bar_items';
    protected $fillable = ['name', 'url', 'icon'];
}
