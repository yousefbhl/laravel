<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Afficher formulaire de connexion ──────────────────────────
    public function showLogin()
    {
        if (session('user_id')) {
            return redirect()->route('posts.index');
        }
        return view('auth.login');
    }

    // ── Traiter la connexion ──────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => "L'email est obligatoire.",
            'email.email'       => "Format d'email invalide.",
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email ou mot de passe incorrect.');
        }

        // Stocker l'ID en session (authentification manuelle)
        session(['user_id' => $user->id]);
        $request->session()->regenerate();

        return redirect()->route('posts.index')
            ->with('success', "Bienvenue, {$user->name} !");
    }

    // ── Afficher formulaire d'inscription ─────────────────────────
    public function showRegister()
    {
        if (session('user_id')) {
            return redirect()->route('posts.index');
        }
        return view('auth.register');
    }

    // ── Traiter l'inscription ─────────────────────────────────────
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:2|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'         => 'Le nom est obligatoire.',
            'name.min'              => 'Le nom doit faire au moins 2 caractères.',
            'email.required'        => "L'email est obligatoire.",
            'email.unique'          => 'Cet email est déjà utilisé.',
            'password.required'     => 'Le mot de passe est obligatoire.',
            'password.min'          => 'Le mot de passe doit faire au moins 6 caractères.',
            'password.confirmed'    => 'Les mots de passe ne correspondent pas.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        session(['user_id' => $user->id]);
        $request->session()->regenerate();

        return redirect()->route('posts.index')
            ->with('success', "Compte créé ! Bienvenue, {$user->name} !");
    }

    // ── Déconnexion ───────────────────────────────────────────────
    public function logout(Request $request)
    {
        session()->forget('user_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté.');
    }
}
