<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Si l'utilisateur n'est pas connecté, ou n'est PAS un gérant
        if (! auth()->check() || ! auth()->user()->can('gerant')) {
            // On le renvoie à l'accueil avec un message d'erreur (ou 403 Forbidden)
            return redirect('/')->with('error', 'Accès interdit. Réservé aux gérants.');
        }

        // Sinon, on le laisse passer
        return $next($request);
    }
}
