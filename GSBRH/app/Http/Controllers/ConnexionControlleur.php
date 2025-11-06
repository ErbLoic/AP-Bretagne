<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Connexion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ConnexionControlleur extends Controller
{
    // Affiche la page de connexion
    public function index()
    {
        return view('Connecter.index');
    }

    public function connecter(Request $request)
    {
        $request->validate([
            'identifiant' => 'required|string',
            'mdp' => 'required|string',
        ]);

        $user = Connexion::where('identifiant', $request->identifiant)->first();
        if ($user && Hash::check($request->mdp, $user->mdp)) {
            if ($user->privilèges == 1) {
                Auth::login($user);

            $request->session()->regenerate();

            return redirect()->intended('praticiens');
            }
            else{
                return back()->withErrors([
                    'identifiant' => 'Vous n\'avez pas les privilèges nécessaires.',
                ])->withInput();
            }
            
        }

        return back()->withErrors([
            'identifiant' => 'Identifiants/Mot de passe incorrects.',
        ])->withInput();
    }

    public function fraude()
    {
        return view('Connecter.fraude');
    }
}
