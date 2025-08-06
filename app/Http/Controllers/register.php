<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\AnneeAcademique;

class register extends Controller
{
    // Méthode pour afficher le formulaire d'inscription
    public function register()
    {
        $classes = Classe::all();
        $annees = AnneeAcademique::all();

        return view('auth.register', compact('classes', 'annees'));
    }

    // Méthode pour le login
    public function login()
    {
        return view('auth.login');
    }

    // Méthode pour l'index
    public function index()
    {
        return view('index');
    }

    public function registerValidation()
    {
        
    }
}
