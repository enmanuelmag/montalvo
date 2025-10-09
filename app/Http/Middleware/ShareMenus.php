<?php

namespace App\Http\Middleware;

use App\Models\LandingFooter;
use App\Models\LandingNav;
use App\Models\LandingTopBar;
use App\Models\RedesSociales;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Menu;
class ShareMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $menus = Menu::whereNull('parent_id')->with('children.children.children.children')->get();
        view()->share('menus', $menus);
        //$user = auth()->user();
        //$topBarContactos = TopBar::first();
        $topBars = LandingTopBar::all();
        $navBars = LandingNav::orderBy('ordenamiento', 'asc')->where('estado',1)->get();
        //$navs = LandingNavServive::getAllActive();
        $footer = LandingFooter::first();

        //View::share('globalUser', $user);
        //View::share('topBarContactos', $topBarContactos);
        View::share('topBar', $topBars);
        View::share('navBars', $navBars);
        View::share('footer', $footer);


        return $next($request);
    }
}
