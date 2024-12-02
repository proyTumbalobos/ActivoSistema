<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ControladorSalir extends Controller
{
    public function VenSalir()
    {
        return view('Inicio');
    }



    public function login(Request $request)
{
    $credentials = $request->validate([
        'dni' => 'required|string',
        'contraseña' => 'required|string',
    ]);

    if (Auth::attempt(['dni' => $credentials['dni'], 'password' => $credentials['contraseña']])) {
        $request->session()->regenerate();
        return redirect()->intended('Principal');
    }

    return back()->withErrors([
        'dni' => 'Las credenciales no coinciden con nuestros registros.',
    ]);
}



    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('salir');
    }
}