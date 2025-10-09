<?php

namespace App\View\Components\Back;

use Illuminate\View\Component;
use Carbon\Carbon;

class WelcomeMessage extends Component
{
    public $greeting;
    public $icon;

    public function __construct()
    {
        $hour = Carbon::now()->format('H');

        if ($hour >= 6 && $hour < 12) {
            $this->greeting = 'Buenos días';
            $this->icon = '☀️'; // Sol
        } elseif ($hour >= 12 && $hour < 18) {
            $this->greeting = 'Buenas tardes';
            $this->icon = '🌤️'; // Sol y nubes
        } else {
            $this->greeting = 'Buenas noches';
            $this->icon = '🌙'; // Luna
        }
    }

    public function render()
    {
        return view('components.back.welcome-message');
    }
}
