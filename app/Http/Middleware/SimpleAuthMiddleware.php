<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SimpleAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('authenticated') || !session()->get('authenticated')) {
            // No autenticado, redirigir a login admin con mensaje
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión para acceder a esta sección');
        }

        return $next($request);
    }
}
