<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckArea
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$areas)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtiene el área del usuario autenticado
            $userArea = Auth::user()->id_area;

            // Verifica si el área del usuario está en la lista permitida
            if (in_array($userArea, $areas)) {
                return $next($request);
            }
        }

        // Si no tiene acceso, redirige o muestra un error
        abort(403, 'Acceso denegado.');
    }
}
