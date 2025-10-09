<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Carbon\Carbon;

class MessageTime extends Component
{
    public $greeting;
    public $icon;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
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

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.message-time');
    }
}
