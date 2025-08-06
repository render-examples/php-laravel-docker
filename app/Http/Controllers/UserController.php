<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function editProfile()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function editProfileleve()
    {
        $user = Auth::user();

        return view('profile.editeleve', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            'telephone' => 'nullable|string|max:20',
            'date_de_naissance' => 'nullable|date',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('telephone')) {
            $user->telephone = $request->telephone;
        }

        if ($request->filled('date_de_naissance')) {
            $user->date_de_naissance = $request->date_de_naissance;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function admineditProfile()
    {
        $user = auth()->user();

        return view('profile.adminedit', compact('user'));
    }

    public function adminupdateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('telephone')) {
            $user->telephone = $request->telephone;
        }

        $user->save();

        return back()->with('success', 'Profil administrateur mis à jour avec succès.');
    }
}
