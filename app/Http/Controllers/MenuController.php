<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    //
    public function index()
    {
        $menus = Menu::whereNull('parent_id')->with('children.children.children.children')->get();
        dd($menus);
        return view('layouts.navigation_new', compact('menus'));
    }
}
