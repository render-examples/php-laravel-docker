<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\AnneeAcademique;

class HomeController extends Controller
{
    /**
     * Page d'accueil
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Formulaire de connexion
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Formulaire d'inscription
     */
    public function register()
    {
        $classes = Classe::all();
        $annees = AnneeAcademique::all();

        return view('auth.register', compact('classes', 'annees'));
    }

    /**
     *
     */
    public function registerValidation(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'classe_id' => 'required|exists:classes,id',
            'annee_academique_id' => 'required|exists:annee_academiques,id',
        ]);

      
        return redirect()->route('home')->with('success', 'Inscription réussie !');
    }
}
