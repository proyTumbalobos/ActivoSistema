<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTipo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$tipo_personas)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtiene el tipo de persona (idTipoPersona) del usuario autenticado
            $userTipoPersona = Auth::user()->idTipoPersona;
    
            // Verifica si el idTipoPersona del usuario está en la lista de tipos permitidos
            if (in_array($userTipoPersona, $tipo_personas)) {
                return $next($request);
            }
        }
    
        // Si no tiene acceso, redirige o muestra un error
        abort(403, 'NO ENTRAR.');
    }
}
