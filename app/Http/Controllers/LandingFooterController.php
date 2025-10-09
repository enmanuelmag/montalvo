<?php

namespace App\Http\Controllers;

use App\Models\LandingFooter;
use Illuminate\Http\Request;

class LandingFooterController extends Controller
{
    //
    public function index()
    {
        $Title = 'Sección Footer';

        $landingFooter = LandingFooter::first();
        return view('backend.footer.footer', compact('Title', 'landingFooter'));
    }

    public function update(Request $request)
    {
        $landingFooter = LandingFooter::find($request->id);
        $landingFooter->titulo_1 = $request->titulo_1;
        $landingFooter->titulo_2 = $request->titulo_2;
        $landingFooter->direccion = $request->direccion;
        $landingFooter->telefono = $request->telefono;
        $landingFooter->email = $request->email;
        $landingFooter->nombreEmpresaFooter = $request->nombreEmpresaFooter;
        $landingFooter->fax = $request->fax;
        $landingFooter->whatsaap_link = $request->whatsaap_link;
        $landingFooter->save();
        return response()->json(['success' => true, 'imagen_path' => '']);
    }
}
