<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfesseurMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est authentifié ET a le rôle "professeur" ou "admin"
        if (auth()->check() && (auth()->user()->role === 'professeur' || auth()->user()->role === 'admin')) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Accès réservé aux professeurs et administrateurs.');
    }
}