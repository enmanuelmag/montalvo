<?php

namespace App\Http\Middleware;

use App\Models\LandingNav;
use App\Models\LandingFooter;
use App\Models\LandingTopBar;
use App\Models\RedesSociales;
use App\Models\TopBar;
use App\Services\LandingNavServive;
use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GlobalViewData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $topBarContactos = TopBar::first();
        $redesSociales = RedesSociales::all();
        $topBar = LandingTopBar::where('estado', 1)->get();
        $navBars = LandingNav::orderBy('ordenamiento', 'asc')->where('estado',1)->get();
        $footer = LandingFooter::first();


        View::share('globalUser', $user);
        View::share('topBarContactos', $topBarContactos);
        View::share('redesSociales', $redesSociales);
        View::share('navBars', $navBars);
        View::share('topBar', $topBar);
        View::share('footer', $footer);


        return $next($request);
    }
}
