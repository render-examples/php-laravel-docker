<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EleveMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est authentifié ET a le rôle "élève"
        if (auth()->check() && auth()->user()->role === 'eleve') {
            return $next($request);
        }

        // Redirige vers une page d'erreur ou la home
        return redirect('/')->with('error', 'Accès réservé aux élèves.');
    }
}