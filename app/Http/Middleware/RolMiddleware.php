<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Middleware que restringe el acceso a rutas según el rol del usuario autenticado.
// Uso en rutas: ->middleware('rol:admin')  o  ->middleware('rol:admin,emprendedor')
class RolMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Si no hay sesión, redirige al login
        if (! $user) {
            return redirect()->route('login');
        }

        // Si el rol del usuario no está dentro de los permitidos, aborta con 403
        if (! in_array($user->rol, $roles, true)) {
            abort(403, 'No tiene permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
