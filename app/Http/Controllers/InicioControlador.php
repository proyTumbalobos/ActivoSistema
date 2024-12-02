<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioControlador extends Controller
{
    public function verinicio()    {
        
        return view('inicio');

    }
}
